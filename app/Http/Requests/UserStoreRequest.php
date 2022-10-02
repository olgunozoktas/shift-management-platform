<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class UserStoreRequest extends FormRequest
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
    #[ArrayShape(['name' => "string", 'email' => "string", 'password' => 'string', 'role' => "string", 'companies' => 'array'])]
    public function rules(): array
    {
        return [
            'name' => 'required|min:2',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'role' => 'required',
            'companies' => 'required',
        ];
    }

    #[ArrayShape([
        'name.required' => "string",
        'name.min' => "string",
        'email.required' => "string",
        'email.unique' => "string",
        'password.required' => 'Password must be entered',
        'role.required' => "string",
        'companies.required' => 'array'
    ])]
    public function messages(): array
    {
        return [
            'name.required' => 'Name must be entered',
            'name.min' => 'Name must be at least 2 characters',
            'email.required' => 'Email must be entered',
            'email.unique' => 'Email is already assigned to another user',
            'password.required' => 'Password must be entered',
            'role.required' => 'Role must be selected',
            'companies.required' => 'Company must be selected'
        ];
    }
}
