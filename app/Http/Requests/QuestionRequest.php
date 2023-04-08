<?php
// \vendor\laravel\framework\src\Illuminate\Foundation\Http\FormRequest.php'

namespace App\Http\Requests;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    $result = AuthController::authorizationAdmin('question.create');
    return $result; //all are authorized to send request
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
      'title' => 'required|string',
      'Answer1' => 'required|string',
      'Answer2' => 'required|string',
      'Answer3' => 'required|string',
      'RightAnswer' => 'required|string',
    ];
  }
}
