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
use Illuminate\Support\Facades\Auth;

class Jobcontroller extends Controller
{
  ////////////////////////////////
  function index()
  {
    $result = AuthController::authorizationAdmin('job.showAll');
    if (!$result) return response()->json([
      'message' => 'unauthorized'
    ], 401);
    $jobs = Job::select('id', 'title', 'description', 'start_date', 'end_data')->with("question")->paginate();
    return response()->json($jobs, 200);
  }

  function show($id)
  {
    $job = Job::where('id', $id)->with("question")->first();
    return response()->json($job);
  }

  function destroy($id)
  {
    $result = AuthController::authorizationAdmin('job.delete');
    if (!$result) return response()->json([
      'message' => 'unauthorized'
    ], 401);
    Question::where('job_id', $id)->delete();
    // $job = Job::find($id);
    // if ($job !== null) $job->user()->detach();
    return response()->json([
      'deleted' => Job::where('id', $id)->delete()
    ], 200);
  }


  function store(StoreJobRequest $request)
  {
    Job::create($request->merge([
      'admin_id' => Auth::guard('sanctum')->user()->id
    ])->all());
    return response()->json(['create' => "created"], 201);
  }

  function edit(JobRequest $request, $id)
  {
    $job = Job::where('id', $id);
    // $job->update($request->except(['_method', '_token']));
    $job->update([
      "title" => $request->title,
      "description" => $request->description,
      "start_date" => $request->start_date,
      "end_data" => $request->end_data
    ]);

    return response()->json(['create' => "created"], 201);
  }

  function count()
  {
    $result = AuthController::authorizationAdmin('job.count');
    if (!$result) return response()->json([
      'message' => 'unauthorized'
    ], 401);
    $jobs = Job::get()->count();
    return response()->json(['count' => $jobs], 200);
  }

  function available()
  {
    $result = AuthController::authorizationUser('job.showAll(available)');
    if (!$result) return response()->json([
      'message' => 'unauthorized'
    ], 401);
    $date = now();
    $job = Job::select('id', 'title', 'description', 'start_date', 'end_data')->where('end_data', '>', $date)->get();
    return response()->json([$job]);
  }

  function search(Request $request)
  {
    $key = $request->key;
    $results = Job::select('title', 'description', 'start_date', 'end_data')->where('title', 'LIKE', "%{$key}%")->get();
    return response()->json(['results' => $results]);
  }
  // nahed
  public function indexcandidate()
  {
    $result = AuthController::authorizationAdmin('candidate.showAll');
    if (!$result) return response()->json([
      'message' => 'unauthorized'
    ], 401);
    $candidates = Job::with('user')->get();
    return response()->json($candidates);
  }
  public function countcandidate()
  {
    $result = AuthController::authorizationAdmin('candidate.count');
    if (!$result) return response()->json([
      'message' => 'unauthorized'
    ], 401);
    $job = Job::with('user')->get();
    for ($i = 0; $i < count($job); $i++) {
      foreach ($job[$i]->user as $user) {
        $result = $user->pivot->count();
      }
    }
    return response()->json(["count" => $result], 200);
  }

  public function searchcandidate(Request $request)
  {
    $result = AuthController::authorizationAdmin('candidate.search');
    if (!$result) return response()->json([
      'message' => 'unauthorized'
    ], 401);
    $characters = $request->input('characters');
    $result = Job::with('user')->where('title', 'LIKE', "%{$characters}%")->get();
    return response()->json($result);
  }
  /**
   * Display the specified resource.
   */
  public function update(PivotRequest $request)
  {
    $job = Job::with('user')->get();
    for ($i = 0; $i < count($job); $i++) {
      foreach ($job[$i]->user as $user) {
        $result = $user->pivot->where('id', $request->id)->update($request->except(['_method', '_token']));
        return response()->json(["message" => $result], 201);
      }
    }
  }
}
