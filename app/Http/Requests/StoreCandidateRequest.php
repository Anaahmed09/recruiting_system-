<?php

namespace App\Http\Requests;

use App\Http\Controllers\AuthController;
use Exception;
use Illuminate\Foundation\Http\FormRequest;

class StoreCandidateRequest extends FormRequest
{
  public function authorize()
  {
    $result = AuthController::authorizationUser('candidate.store');
    // if (!$result) throw new Exception('Unauthorized');
    // return $result;
    // dd($result);
    // if (!$result) {
    //   return response()->json([
    //     'message' => 'Unauthorized'
    //   ], 401);
    // }
    return $result;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
   */
  public function rules(): array
  {
    return [
      'job_id' => 'required|exists:jobs,id',
      'numbers_of_wrong_answers' => 'required|digits_between:1,2',
      'numbers_of_right_answers' => 'required|digits_between:1,2'
    ];
  }
}
