<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Contracts\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    $credentials = $request->only(['email', 'password']);
    if (Auth::attempt($credentials)) {
      $token = Auth::user()->createToken('token-name', ['userTest'])->plainTextToken;
      return response()->json(['token' => $token]);
    }
    return response()->json(['error' => 'Unauthorized'], 401);
  }
  public function test()
  {
    $users = User::get();
    if (Auth::user()->tokenCan('userTest')) {
      return response()->json([
        'error' => 'false',
        'data' => 'true',
      ]);
    }
    return response()->json([
      ['error' => 'true'], 401
    ]);
  }
}
