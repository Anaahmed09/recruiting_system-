<?php

namespace App\Http\Requests;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
{
  public function authorize(): bool
  {
    $result = AuthController::authorizationAdmin('job.create');
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
      'title' => 'required|string|min:5|max:20',
      'description' => 'required|string',
      'start_date' => 'required|date',
      'end_data' => 'required|date',
    ];
  }
}
