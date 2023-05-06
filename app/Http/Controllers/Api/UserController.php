<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCandidateRequest;
use App\Models\User;
use App\Models\Job;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
  use ApiResponseTrait;
  /**
   * Display a listing of the resource.
   */



  public function index()
  {
    $result = AuthController::authorizationUser('user.idsJOb');
    if (!$result) return response()->json([
      'message' => 'unauthorized'
    ], 401);
    $user = Auth::guard('sanctum')->user();
    $job_ids =  $user->jobs()->select('job_id')->get();
    return response()->json($job_ids, 200);
  }


  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|string',
      'email' => 'required|string|email|max:100|unique:users',
      'username' => 'required|string|unique:users',
      'password' => 'required|min:8',
      'img' => 'string',
      'phone' => 'required|string',
      'address' => 'string',
      'state' => 'string',
      'city' => 'string'
    ]);
    $request['password'] = bcrypt($request->password);
    if ($validator->fails()) {
      return response()->json(['message' => $validator->errors()], 400);
    }
    $user = User::create($request->all());
    if ($user) {
      return response()->json(["user" => $user, 'message' => 'created'], 201);
    } else {
      return response()->json(['message' => 'created error'], 400);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show()
  {
    $result = AuthController::authorizationUser('user.show');
    if (!$result) return response()->json([
      'message' => 'unauthorized'
    ], 401);
    $user = Auth::guard('sanctum')->user();
    return response()->json($user, 200);
  }


  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request)
  {
    $result = AuthController::authorizationUser('user.update');
    if (!$result) return response()->json([
      'message' => 'unauthorized'
    ], 401);

    $validator = Validator::make($request->all(), [
      'name' => 'required|string',
      'phone' => 'required|numeric|digits:11',
      'address' => 'string',
      'state' => 'string',
      'city' => 'string'
    ]);

    if ($validator->fails()) {
      return response()->json(['message' => 'validation error'], 400);
    }
    $user = Auth::guard('sanctum')->user();
    if (!$user) {
      return response()->json(['message' => 'this user not found'], 404);
    }
    $user->update($request->all());
    if ($user) {
      return response()->json(['message' => 'updated'], 201);
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  // public function destroy(string $id)
  // {
  //   $user = User::find($id);
  //   $user->jobs()->detach();
  //   if (!$user) {
  //     return $this->apiResponse(null, 404, 'the user not found');
  //   }
  //   $user->destroy($id);
  //   if ($user) {
  //     return $this->apiResponse(null, 200, 'ok');
  //   }
  // }
  //
  public function showcandidate()
  {
    $result = AuthController::authorizationUser('candidate.status');
    if (!$result) return response()->json([
      'message' => 'unauthorized'
    ], 401);
    $user = Auth::guard('sanctum')->user();
    $users = $user->jobs()->get();
    foreach ($users as $users) {
      $result = $users->pivot->select('status', 'numbers_of_right_answers', 'numbers_of_wrong_answers')
        ->where('user_id', $user->id)->get();
        $job_ids=$users->pivot->select('job_id')->where('user_id', $user->id)->get();
        $result2=array();
        $result3=array();
        for ($i=0; $i <count( $job_ids) ; $i++) {
          $result2[$i]=Job::select('title','id')->where('id',$job_ids[$i]['job_id'])->get();
          $result3[$i]=Question::where('job_id',$job_ids[$i]['job_id'])->get()->count();
        }
    }
    return response()->json(['candidate'=>$result ,'job'=>$result2,'count'=>$result3]);
  }
  public function storeCandidate(StoreCandidateRequest $request)
  {
    $user = Auth::guard('sanctum')->user();
    $user->jobs()->attach($request->job_id, $request->all());
    return response()->json([
      'message' => 'created'
    ], 201);
  }
}
