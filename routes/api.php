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

Route::post('login', [AuthController::class, 'login']);
Route::get('test', [AuthController::class, 'test'])->middleware('auth:sanctum');


//APIs for  Questions ..
Route::get('/Question',[QuestionController::class,'index']);
Route::post('/Question',[QuestionController::class,'store']);
Route::get('/Question/{id}', [QuestionController::class, 'show']);
Route::delete('/Question/{id}', [QuestionController::class, 'destroy']);
Route::get('/SearchQuestion',[QuestionController::class,'SearchQuestion']);
Route::put('/Question/{id}', [QuestionController::class, 'edit']);





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
