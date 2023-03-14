<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
  use ApiResponseTrait;
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $users = User::with('jobs')->paginate();
    return $this->apiResponse($users, 200, 'ok');
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
      'img' => 'string',
      'phone' => 'required|numeric|digits:11',
      'address' => 'string',
      'state' => 'string',
      'city' => 'string'
    ]);
    if ($validator->fails()) {
      return $this->apiResponse(null, 400, $validator->errors());
    }
    $user = User::create($request->all());
    if ($user) {
      return $this->apiResponse($user, 201, 'ok');
    } else {
      return $this->apiResponse(null, 400, 'the user not createds');
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $user = User::with('jobs')->find($id);
    if ($user) {
      return $this->apiResponse($user, 200, 'ok');
    } else {
      return $this->apiResponse(null, 404, 'the user not found');
    }
  }


  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|string',
      'phone' => 'required|numeric|digits:11',
      'address' => 'string',
      'state' => 'string',
      'city' => 'string'
    ]);
    if ($validator->fails()) {
      return $this->apiResponse(null, 400, $validator->errors());
    }
    $user = User::find($id);
    if (!$user) {
      return $this->apiResponse(null, 404, 'The post not found');
    }
    $user->update($request->all());
    if ($user) {
      return $this->apiResponse($user, 200, 'ok');
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {

    $user = User::find($id);
    $user->jobs()->detach();

    if (!$user) {
      return $this->apiResponse(null, 404, 'the user not found');
    }
    $user->destroy($id);
    if ($user) {
      return $this->apiResponse(null, 200, 'ok');
    }
  }
}
