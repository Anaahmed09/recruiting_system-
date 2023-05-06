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
use PhpParser\Node\Stmt\TryCatch;

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

  public function show($job_id)
  {
    $result = AuthController::authorizationUser('question.show');
    if (!$result)
      $result = AuthController::authorizationAdmin('question.show');
    if (!$result) return response()->json([
      'message' => 'unauthorized'
    ], 401);
    $Questions = Question::where('Job_id', $job_id)->get();
    return response()->json(['data' => $Questions], 200);
  }

  public function showToEdit($question_id)
  {
    $result = AuthController::authorizationUser('question.show');
    if (!$result)
      $result = AuthController::authorizationAdmin('question.show');
    if (!$result) return response()->json([
      'message' => 'unauthorized'
    ], 401);
    $Question = Question::where('id', $question_id)->first();
    return response()->json(['data' => $Question], 200);
  }

  /**
   * Display the specified resource with id
   */
  public function showQuestionsByIdJob($id, Request $request)
  {
    try {
      $job = Job::with('question')->where('id', $id)->first();
      $question = $job->question()->paginate($request->input('pre_page', 1));
      return response()->json($question, 200);
    } catch (\Throwable $th) {
      return response()->json(['Message' => 'Server is not available now please try again later '], 503);
    }
  }
  public function showAllQuestions(Question $question)
  {
    try {
      return response()->json($question, 200);
    } catch (\Throwable $th) {
      return response()->json(['Message' => 'Server is not available now please try again later '], 503);
    }
  }

  // public function show($job_id)
  // {
  //   $Questions = Question::where('Job_id', $job_id)->get();
  //   return response()->json(['data' => $Questions], 200);
  // }


  /**
   * Display the specified question with it's name
   */
  public function SearchQuestion(SearchQuestion $request)
  {
    try {
      $characters = $request->title;
      $Question = Question::where('title', 'LIKE', "%{$characters}%")->where('job_id', $request->id)->get();
      return response()->json($Question, 200);
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
