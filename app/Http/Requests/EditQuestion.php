<?php

namespace App\Http\Requests;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Http\FormRequest;

class EditQuestion extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    $result = AuthController::authorizationAdmin('question.edit');
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
      'title' => 'required|string',
      'description' => 'required|string',
      'Answer1' => 'required|string',
      'Answer2' => 'required|string',
      'Answer3' => 'required|string',
      'RightAnswer' => 'required|string'
    ];
  }
}
