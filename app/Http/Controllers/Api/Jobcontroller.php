<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AuthController;
use App\Models\Job;
use App\Models\Question;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\JobRequest;
use App\Http\Requests\PivotRequest;
use App\Http\Requests\StoreJobRequest;

class Jobcontroller extends Controller
{
  // $result = AuthController::authorizationAdmin('candidate.showAll');
  // if (!$result) return response()->json([
  //   'message' => 'unauthorized'
  // ], 401);
  // $result = AuthController::authorizationAdmin('candidate.acceptOrReject');
  // if (!$result) return response()->json([
  //   'message' => 'unauthorized'
  // ], 401);
  // $result = AuthController::authorizationAdmin('candidate.count');
  // if (!$result) return response()->json([
  //   'message' => 'unauthorized'
  // ], 401);
  // $result = AuthController::authorizationAdmin('candidate.search');
  // if (!$result) return response()->json([
  //   'message' => 'unauthorized'
  // ], 401);
  ////////////////////////////////
  // $result = AuthController::authorizationUser('candidate.status');
  // if (!$result) return response()->json([
  //   'message' => 'unauthorized'
  // ], 401);
  // $result = AuthController::authorizationUser('candidate.store');
  // if (!$result) return response()->json([
  //   'message' => 'unauthorized'
  // ], 401);
  function index()
  {
    $result = AuthController::authorizationAdmin('job.showAll');
    if (!$result) return response()->json([
      'message' => 'unauthorized'
    ], 401);
    $jobs = Job::paginate();
    return response()->json(['jobs' => $jobs]);
  }

  function show($id)
  {
    $job = Job::where('id', $id)->get();
    return response()->json(['job' => $job]);
  }

  function destroy($id)
  {
    $result = AuthController::authorizationAdmin('job.delete');
    if (!$result) return response()->json([
      'message' => 'unauthorized'
    ], 401);
    Question::where('job_id', $id)->delete();
    $job = Job::with('user')->get();

    for ($i = 0; $i < count($job); $i++) {
      foreach ($job[$i]->user as $user) {
        $pivot = $user->pivot->where('job_id', $id)->delete();
      }
    }

    Job::where('id', $id)->delete();
  }


  function store(StoreJobRequest $request)
  {
    $jobcreate = [
      'title' => $request->input('title'),
      'description' => $request->input('description'),
      'start_date' => $request->input('start_date'),
      'end_data' => $request->input('end_data'),
      'admin_id' => $request->input('admin_id')
      // 'admin_id'=> Auth::Admin()->id

    ];

    $job = Job::create($request->all());
    // $job = Job::create($jobcreate);
    return response()->json(['job' => $job]);
  }

  function edit(JobRequest $request, $id)
  {
    $job = Job::where('id', $id);
    $job->update($request->except(['_method', '_token']));
  }

  function count()
  {
    $result = AuthController::authorizationAdmin('job.count');
    if (!$result) return response()->json([
      'message' => 'unauthorized'
    ], 401);
    $jobs = Job::get()->count();
    return response()->json(['jobcount' => $jobs]);
  }

  function available()
  {
    $result = AuthController::authorizationUser('job.showAll(available)');
    if (!$result) return response()->json([
      'message' => 'unauthorized'
    ], 401);
    $date = now();
    $job = Job::where('end_data', '>', $date)->get();
    return response()->json([$job]);
  }

  function search(Request $request)
  {
    $key = $request->key;
    $results = Job::where('title', 'LIKE', "%{$key}%")->get();
    return response()->json(['results' => $results]);
  }
  // nahed
  public function indexcandidate()
  {
    // 1---candidates of each job (candidates info and jop info and status and score)
    $candidates = Job::with('user')->get();
    return response()->json($candidates);
  }


  public function countcandidate()
  {
    // 4---count all candidates
    $job = Job::with('user')->get();
    for ($i = 0; $i < count($job); $i++) {
      foreach ($job[$i]->user as $user) {
        $result = $user->pivot->count();
      }
    }
    return response()->json($result);
  }

  public function searchcandidate(Request $request)
  {

    // 5---search about job candidates
    $characters = $request->input('characters');
    $result = Job::with('user')->where('title', 'LIKE', "%{$characters}%")->get();
    return response()->json($result);
  }
  /**
   * Display the specified resource.
   */
  public function showcandidate(string $user_id)
  {
    // 3---show candidates by user_id
    $job = Job::with('user')->get();
    for ($i = 0; $i < count($job); $i++) {
      foreach ($job[$i]->user as $user) {
        $result = $user->pivot->where('user_id', $user_id)->get();
        return response()->json($result);
      }
    }
  }


  public function update(PivotRequest $request, string $job_id, string $user_id)
  {
    // 2---update candidates status
    $job = Job::with('user')->get();
    for ($i = 0; $i < count($job); $i++) {
      foreach ($job[$i]->user as $user) {
        $result = $user->pivot->where('user_id', $user_id)->where('job_id', $job_id)->update($request->except(['_method', '_token']));
      }
    }
  }
}
