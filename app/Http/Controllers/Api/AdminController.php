<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    // $result = AuthController::authorizationAdmin('job.create');
    // if (!$result) return response()->json([
    //   'message' => 'unauthorized'
    // ], 401);
    // $result = AuthController::authorizationAdmin('job.count');
    // if (!$result) return response()->json([
    //   'message' => 'unauthorized'
    // ], 401);
    // $result = AuthController::authorizationAdmin('job.showAll');
    // if (!$result) return response()->json([
    //   'message' => 'unauthorized'
    // ], 401);
    // $result = AuthController::authorizationAdmin('job.edit');
    // if (!$result) return response()->json([
    //   'message' => 'unauthorized'
    // ], 401);
    // $result = AuthController::authorizationAdmin('job.delete');
    // if (!$result) return response()->json([
    //   'message' => 'unauthorized'
    // ], 401);
    ////////////
    // $result = AuthController::authorizationAdmin('question.create');
    // if (!$result) return response()->json([
    //   'message' => 'unauthorized'
    // ], 401);

    // $result = AuthController::authorizationAdmin('question.edit');
    // if (!$result) return response()->json([
    //   'message' => 'unauthorized'
    // ], 401);
    // $result = AuthController::authorizationAdmin('question.delete');
    // if (!$result) return response()->json([
    //   'message' => 'unauthorized'
    // ], 401);
    // $result = AuthController::authorizationAdmin('question.count');
    // if (!$result) return response()->json([
    //   'message' => 'unauthorized'
    // ], 401);
    // $result = AuthController::authorizationAdmin('question.search');
    // if (!$result) return response()->json([
    //   'message' => 'unauthorized'
    // ], 401);
    ////////////////////////////
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
    /////////////////////////////////////////////////////////////////////////////////////
    // $result = AuthController::authorizationUser('job.showAll(available)');
    // if (!$result) return response()->json([
    //   'message' => 'unauthorized'
    // ], 401);

    // $result = AuthController::authorizationUser('candidate.status');
    // if (!$result) return response()->json([
    //   'message' => 'unauthorized'
    // ], 401);

    // $result = AuthController::authorizationUser('candidate.store');
    // if (!$result) return response()->json([
    //   'message' => 'unauthorized'
    // ], 401);

    // $result = AuthController::authorizationUser('user.show');
    // if (!$result) return response()->json([
    //   'message' => 'unauthorized'
    // ], 401);
    // $result = AuthController::authorizationUser('user.update');
    // if (!$result) return response()->json([
    //   'message' => 'unauthorized'
    // ], 401);
    // $result = AuthController::authorizationUser('user.idsJOb');
    // if (!$result) return response()->json([
    //   'message' => 'unauthorized'
    // ], 401);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // $user = Auth::guard('sanctum')->user();
    $user = User::find(3);
    $user->jobs()->attach($request->job_id, $request->all());
    return response()->json([
      'message' => 'created'
    ], 201);
  }

  /**
   * Display the specified resource.
   */
  public function show(Admin $admin)
  {
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Admin $admin)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Admin $admin)
  {
    //
  }
}
