<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\QuestionController;
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

Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::get('jobs', [JobController::class, 'index']);
  Route::get('show/{id}', [JobController::class, 'show']);
  Route::put('/job/{job}', [JobController::class, 'update']);
  Route::delete('/job/{job}', [JobController::class, 'destroy']);
  Route::post('/job', [JobController::class, 'store']);
  Route::get('/job.count', [JobController::class, 'count']);
  Route::get('/job.available', [JobController::class, 'available']);
  Route::get('/job.search', [JobController::class, 'search']);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::get('/question', [QuestionController::class, 'index']);
  Route::post('/question', [QuestionController::class, 'store']);
  Route::get('/question/{question}', [QuestionController::class, 'show']);
  Route::delete('/Question/{question}', [QuestionController::class, 'destroy']);
  Route::get('/question.search', [QuestionController::class, 'SearchQuestion']);
  Route::put('/question/{question}', [QuestionController::class, 'edit']);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::get('/user', [UserController::class, 'index']);
  Route::post('/user', [UserController::class, 'store']);
  Route::get('/user/{user}', [UserController::class, 'show']);
  Route::put('/user/{user}', [UserController::class, 'update']);
  Route::delete('/user/{user}', [UserController::class, 'destroy']);
});

// Route::group(['middleware' => ['auth:sanctum']], function () {
//   Route::get('jobs', [JobController::class, 'index']);
//   Route::get('show/{id}', [JobController::class, 'show']);
//   Route::put('update/{id}', [JobController::class, 'edit']);
//   Route::delete('destroy/{id}', [JobController::class, 'destroy']);
//   Route::post('store', [JobController::class, 'store']);
//   Route::get('count', [JobController::class, 'count']);
//   Route::get('available', [JobController::class, 'available']);
//   Route::get('search', [JobController::class, 'search']);
// });
// Route::group(['middleware' => ['auth:sanctum']], function () {
//   Route::get('/admin', [AdminController::class, 'index']);
//   Route::post('/admin', [AdminController::class, 'store']);
//   Route::get('/admin/{admin}', [AdminController::class, 'show']);
//   Route::put('/admin/{admin}', [AdminController::class, 'update']);
//   Route::delete('/admin/{admin}', [AdminController::class, 'destroy']);
// });
// Route::group(['middleware' => ['auth:sanctum']], function () {
//   Route::get('/Question', [QuestionController::class, 'index']);
//   Route::post('/Question', [QuestionController::class, 'store']);
//   Route::get('/Question/{id}', [QuestionController::class, 'show']);
//   Route::delete('/Question/{id}', [QuestionController::class, 'destroy']);
//   Route::get('/SearchQuestion', [QuestionController::class, 'SearchQuestion']);
//   Route::put('/Question/{id}', [QuestionController::class, 'edit']);
// });

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


// Route::apiResource('admin', AdminController::class);
// Route::apiResource('job', JobController::class);
// Route::apiResource('question', QuestionController::class);
// Route::apiResource('user', UserController::class);






