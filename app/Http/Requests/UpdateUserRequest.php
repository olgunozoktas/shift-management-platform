<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if(isAdmin() || isSuperAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['name' => "string", 'email' => "string", 'password' => 'string', 'role' => "string"])]
    public function rules(): array
    {
        return [
            'name' => 'required|min:2',
            'password' => 'nullable',
            'role' => 'required'
        ];
    }

    #[ArrayShape(['name.required' => "string", 'name.min' => "string", 'password.required' => 'Password must be entered', 'role.required' => "string"])]
    public function messages(): array
    {
        return [
            'name.required' => 'Name must be entered',
            'name.min' => 'Name must be at least 2 characters',
            'password.required' => 'Password must be entered',
            'role.required' => 'Role must be selected'
        ];
    }
}
