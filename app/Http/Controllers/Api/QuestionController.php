<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditQuestion;
use App\Http\Requests\QuestionRequest;
use App\Http\Requests\SearchQuestion;
use App\Models\Job;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
  public function index()
  {
    $result = AuthController::authorizationAdmin('question.count');
    if (!$result) return response()->json([
      'message' => 'unauthorized'
    ], 401);
    $Questions = Question::get();
    return response()->json(['count' => $Questions->count()], 200);
  }

  /**
   * create a question and insert all data in database
   */
  public function store(QuestionRequest $request)
  {
    try {
      Question::create($request->all());
      return response()->json(['created' => 'created'], 201);
    } catch (\Throwable $th) {
      return response()->json(['Message' => 'Server is not available now please try again later '], 503);
    }
  }

  /**
   * Display the specified resource with id
   */
  // public function show($id)
  // {
  //   try {
  //     $Questions = Job::with('question')->where('id', $id)->get();
  //     return response()->json(['data' => $Questions], 200);
  //   } catch (\Throwable $th) {
  //     return response()->json(['Message' => 'Server is not available now please try again later '], 503);
  //   }
  // }


  /**
   * Display the specified question with it's name
   */
  public function SearchQuestion(SearchQuestion $request)
  {
    try {
      $characters = $request->title;
      $Question = Question::select('title', 'description', 'Answer1', 'Answer2', 'Answer3', 'RightAnswer')
        ->where('title', 'LIKE', "%{$characters}%")->get();
      return response()->json(['results' => $Question], 200);
    } catch (\Throwable $th) {
      return response()->json(['Message' => 'Server is not available now please try again later '], 503);
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function edit(EditQuestion $request, $id)
  {
    try {
      return response()->json(['updated' => Question::where('id', $id)->update($request->all())], 201);
    } catch (\Throwable $th) {
      return response()->json(['Message' => 'Server is not available now please try again later '], 503);
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    $result = AuthController::authorizationAdmin('question.delete');
    if (!$result) return response()->json([
      'message' => 'unauthorized'
    ], 401);
    try {
      $Question = Question::where('id', $id);
      $Question->delete();
      return response()->json(['Message' => 'deleted', 200]);
    } catch (\Throwable $th) {
      return response()->json(['Message' => 'Server is not available now please try again later '], 503);
    }
  }
}
