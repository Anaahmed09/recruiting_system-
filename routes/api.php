<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\Jobcontroller;
use App\Http\Controllers\Api\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
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
Route::get('isLoggedIn', [AuthController::class, 'isLoggedIn'])->middleware('auth:sanctum');

Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::get('/job', [JobController::class, 'index']);
  Route::get('/job/{id}', [JobController::class, 'show']);
  Route::put('/job/{job}', [JobController::class, 'edit']);
  Route::delete('/job/{job}', [JobController::class, 'destroy']);
  Route::post('/job', [JobController::class, 'store']);
  Route::get('/job.count', [JobController::class, 'count']);
  Route::get('/job.available', [JobController::class, 'available']);
  Route::get('/job.search', [JobController::class, 'search']);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
  route::get('/candidate', [JobController::class, 'indexcandidate']);
  route::get('/candidate.count', [JobController::class, 'countcandidate']);
  Route::get('/candidate.search', [JobController::class, 'searchcandidate']);
  route::put('/candidate', [JobController::class, 'update']);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::get('/question', [QuestionController::class, 'index']);
  Route::post('/question', [QuestionController::class, 'store']);
  Route::delete('/question/{question}', [QuestionController::class, 'destroy']);
  Route::post('/question.search', [QuestionController::class, 'SearchQuestion']);
  Route::put('/question/{question}', [QuestionController::class, 'edit']);
  Route::get('/questions.job/{job_id}', [QuestionController::class, 'showQuestionsByIdJob']);
  Route::get('/question/{question}', [QuestionController::class, 'show']);
  Route::get('/question.showAll/{question}', [QuestionController::class, 'showAllQuestions']);
});

Route::post('/user', [UserController::class, 'store']);

Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::get('/user', [UserController::class, 'index']);
  Route::get('/user/{id}', [UserController::class, 'show']);
  Route::put('/user/{id}', [UserController::class, 'update']);
  route::get('/candidate.show', [UserController::class, 'showcandidate']);
  Route::post('/candidate.store', [UserController::class, 'storeCandidate']);
  // Route::delete('/user/{user}', [UserController::class, 'destroy']);
});

// Route::apiResource('admin', AdminController::class);
// Route::apiResource('job', JobController::class);
// Route::apiResource('question', QuestionController::class);
// Route::apiResource('user', UserController::class);
