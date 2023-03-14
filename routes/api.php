<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\JobController;
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


Route::post('login', [AuthController::class, 'login']);
Route::get('test', [AuthController::class, 'test'])->middleware('auth:sanctum');

Route::get('jobs',[JobController::class,'index']);
Route::get('show/{id}',[JobController::class,'show']);

Route::put('update/{id}',[JobController::class,'edit']);

Route::delete('destroy/{id}',[JobController::class,'destroy']);

Route::post('store',[JobController::class,'store']);

Route::get('count',[JobController::class,'count']);


Route::get('available',[JobController::class,'available']);

Route::get('search',[JobController::class,'search']);



// Route::apiResource('admin', AdminController::class);
// Route::apiResource('job', JobController::class);
// Route::apiResource('question', QuestionController::class);



// Route::group(['middleware' => ['auth:sanctum']], function () {
//   Route::get('/admin', [AdminController::class, 'index']);
//   Route::post('/admin', [AdminController::class, 'store']);
//   Route::get('/admin/{admin}', [AdminController::class, 'show']);
//   Route::put('/admin/{admin}', [AdminController::class, 'update']);
//   Route::delete('/admin/{admin}', [AdminController::class, 'destroy']);
// });
