<?php

namespace App\Http\Requests;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Http\FormRequest;

class PivotRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize()
  {
    $result = AuthController::authorizationAdmin('candidate.acceptOrReject');
    if (!$result) return response()->json([
      'message' => 'unauthorized'
    ], 401);
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
      'id' => 'required|exists:job_user,id',
      'status' => 'in:pending,accepted,rejected',
    ];
  }
}
