<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
            'title'=> 'required|string|min:5|max:20',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_data' => 'required|date',
            'admin_id' => 'required|exists:admins,id'
        ];
    }
}