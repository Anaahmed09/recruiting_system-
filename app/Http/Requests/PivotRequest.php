<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PivotRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id'=> 'required|exists:users,id',
            'job_id' => 'required|exists:jobs,id',
            'numbers_of_wrong_answers' => 'required|digits_between:1,2',
            'numbers_of_right_answers' => 'required|digits_between:1,2',
            'status' => 'in:pending, accepted,rejected',
        ];
    }
}
