<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
  /**
   * Display all Questions using api from database
   */
  public function index()
  {
    $Questions = Question::get();
    return response()->json(['data' => $Questions]);
  }

  /**
   * create a question and insert all data in database
   */
  public function store(QuestionRequest $request)
  {
        try
        {
          $Questions = Question::create($request->all());
        }
        catch(\Throwable $th)
        {
          return response()->json(['Message' => 'Server is not available now please try again later '],503);
        }

    return response()->json(['data' => $Questions],201);
  }

  /**
   * Display the specified resource.
   */
  public function show(Question $Question)
  {
    try
    {
      $Question = Question::find($Question);
    }
    catch(\Throwable $th)
    {
      return response()->json(['Message' => 'Server is not available now please try again later '],503);
    }

    return response()->json(['data' => $Question],201);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(QuestionRequest $request, Question $Question)
  {
    try
    {
      $Question = Question::find($Question);
      $Question = $Question->update($request->all());
    }
    catch(\Throwable $th)
    {
      return response()->json(['Message' => 'Server is not available now please try again later '],503);
    }

    return response()->json(['data' => $Question],201);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Question $Question)
  {

    try
    {
      $Question = Question::find($Question);
      $Question->delete();
    }
    catch(\Throwable $th)
    {
      return response()->json(['Message' => 'Server is not available now please try again later '],503);
    }

return response()->json(['Message' => 'You deleted a question successfully ',201]);
  }
}
