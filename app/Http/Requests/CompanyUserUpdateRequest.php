<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class CompanyUserUpdateRequest extends FormRequest
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
    #[ArrayShape(['phone_no' => 'string'])]
    public function rules(): array
    {
        return [
            'phone_no' => 'required|min:2',
        ];
    }

    #[ArrayShape([
        'phone_no.required' => "string", 'phone_no.min' => "string",
    ])]
    public function messages(): array
    {
        return [
            'phone_no.required' => 'Phone no must be entered',
            'phone_no.min' => 'Phone no must be at least 2 characters',
        ];
    }
}
