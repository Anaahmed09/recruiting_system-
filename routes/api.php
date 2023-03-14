<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::delete('logout/{token?}', [AuthController::class, 'logout'])->name('logout')
  ->middleware('auth:sanctum');

Route::get('test', [AuthController::class, 'test'])->middleware('auth:sanctum');

Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::get('/admin', [AdminController::class, 'index']);
  Route::post('/admin', [AdminController::class, 'store']);
  Route::get('/admin/{admin}', [AdminController::class, 'show']);
  Route::put('/admin/{admin}', [AdminController::class, 'update']);
  Route::delete('/admin/{admin}', [AdminController::class, 'destroy']);
});
// Route::group(['middleware' => ['auth:sanctum']], function () {
//   Route::get('/job', [JobController::class, 'index']);
//   Route::post('/job', [JobController::class, 'store']);
//   Route::get('/job/{job}', [JobController::class, 'show']);
//   Route::put('/job/{job}', [JobController::class, 'update']);
//   Route::delete('/job/{job}', [JobController::class, 'destroy']);
// });
// Route::group(['middleware' => ['auth:sanctum']], function () {
//   Route::get('/question', [QuestionController::class, 'index']);
//   Route::post('/question', [QuestionController::class, 'store']);
//   Route::get('/question/{question}', [QuestionController::class, 'show']);
//   Route::put('/question/{question}', [QuestionController::class, 'update']);
//   Route::delete('/question/{question}', [QuestionController::class, 'destroy']);
// });
// Route::group(['middleware' => ['auth:sanctum']], function () {
//   Route::get('/user', [UserController::class, 'index']);
//   Route::post('/user', [UserController::class, 'store']);
//   Route::get('/user/{user}', [UserController::class, 'show']);
//   Route::put('/user/{user}', [UserController::class, 'update']);
//   Route::delete('/user/{user}', [UserController::class, 'destroy']);
// });

// Route::apiResource('admin', AdminController::class);
// Route::apiResource('job', JobController::class);
// Route::apiResource('question', QuestionController::class);
// Route::apiResource('user', UserController::class);
