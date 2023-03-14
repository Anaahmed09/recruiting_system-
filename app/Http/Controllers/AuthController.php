<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Laravel\Sanctum\Contracts\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    $credentials = $request->only(['username', 'password']);
    $device_name = (string) $request->post('device_name', $request->userAgent());
    if (Auth::guard('admins')->attempt($credentials)) {
      $authUser = Auth::guard('admins')->user();
      $admin = Admin::find($authUser->id);
      $abilities = [
        'job.create', 'job.showAll', 'job.edit', 'job.delete',
        'question.create', 'question.show', 'question.edit', 'question.delete',
        'candidate.showAll', 'candidate.acceptOrReject'
      ];
      $token = $admin->createToken($device_name, $abilities, now()->addDays(1))->plainTextToken;
      return response()->json([
        'token' => $token,
        'user' => Auth::guard('admins')->user()->name,
      ], 200);
    } elseif (Auth::guard('users')->attempt($credentials)) {
      $authUser = Auth::guard('users')->user();
      $user = User::find($authUser->id);
      $abilities = [
        'job.showAll(available)', 'question.show', 'candidate.status',
        'user.show', 'user.update'
      ];
      $token = $user->createToken($device_name, $abilities, Carbon::now()->addHours(3))->plainTextToken;
      return response()->json([
        'token' => $token,
        'user' => Auth::guard('users')->user(),
      ], 200);
    } else {
      return response()->json([
        'error' => 'Unauthorized'
      ], 401);
    }
  }
  public function logout($token = null)
  {
    $user = Auth::guard('sanctum')->user();
    $personalAccessToken = PersonalAccessToken::findToken($token); // find this token form database
    if ($token === null) {
      $user->currentAccessToken()->delete();
      return response()->json([
        'Message' => 'logout successful'
      ], 204);
    }
    if (
      $personalAccessToken !== null &&
      $user->id == $personalAccessToken->tokenable_id &&
      get_class($user) == $personalAccessToken->tokenable_type
    ) {
      $personalAccessToken->delete();
      return response()->json([
        'Message' => 'logout successful'
      ], 204);
    }
    if ($token == 'destroy') {
      $user->tokens()->delete();
      return response()->json([
        'Message' => 'logout form all devices successful'
      ], 204);  // no content
    }
  }
  public static function authorizationAdmin($ability)
  {
    $user = Auth::guard('sanctum')->user();
    if (get_class($user) == Admin::class &&  $user->tokenCan($ability)) {
      return true;
    }
    return false;
  }
  public static function authorizationUser($ability)
  {
    $user = Auth::guard('sanctum')->user();
    if (get_class($user) == User::class &&  $user->tokenCan($ability)) {
      return response()->json([
        'error' => 'false',
        'data' => $ability
      ], 200);
    }
    return response()->json([
      'error' => 'true',
      'data' => $ability
    ], 401);
  }
}
