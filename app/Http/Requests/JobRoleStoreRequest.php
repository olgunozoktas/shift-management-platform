<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class JobRoleStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if(isAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['definition' => "string"])]
    public function rules(): array
    {
        return [
            'definition' => 'required|min:2',
        ];
    }

    #[ArrayShape(['definition.required' => "string", 'definition.min' => "string"])]
    public function messages(): array
    {
        return [
            'definition.required' => 'Definition must be entered',
            'definition.min' => 'Definition must be at least 2 characters',
        ];
    }
}
