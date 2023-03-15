<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AuthController;
use App\Models\Job;
use App\Models\Question;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\JobRequest;
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
}
