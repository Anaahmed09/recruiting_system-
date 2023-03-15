<?php

namespace App\Http\Requests;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Http\FormRequest;

class SearchQuestion extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    $result = AuthController::authorizationAdmin('question.search');
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
    ];
  }
}
