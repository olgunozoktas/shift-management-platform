<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class ShiftStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if(isCompanyAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['date_time' => "string", 'type' => 'string', 'job_role_id' => 'string', 'text' => 'string'])]
    public function rules(): array
    {
        return [
            'date_time' => 'required|min:2',
            'type' => 'required',
            'job_role_id' => 'required',
            'text' => 'required',
        ];
    }

    #[ArrayShape([
        'date_time.required' => "string", 'date_time.min' => "string",
        'type.required' => "string",
        'job_role_id.required' => "string",
        'text.required' => "string",
    ])]
    public function messages(): array
    {
        return [
            'date_time.required' => 'Date time must be entered',
            'date_time.min' => 'Date time must be at least 2 characters',
            'type.required' => 'Type must be entered',
            'job_role_id.required' => 'Job role must be entered',
            'text.required' => 'Text must be entered',
        ];
    }
}
