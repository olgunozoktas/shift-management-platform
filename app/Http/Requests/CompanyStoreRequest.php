<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class CompanyStoreRequest extends FormRequest
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
    #[ArrayShape(['name' => "string", 'email' => 'string', 'phone_no' => 'string', 'notification_type' => 'string'])]
    public function rules(): array
    {
        return [
            'name' => 'required|min:2',
            'email' => 'required|min:2|email',
            'phone_no' => 'required|min:2',
            'notification_type' => 'required|min:2',
        ];
    }

    #[ArrayShape([
        'name.required' => "string", 'name.min' => "string",
        'email.required' => "string", 'email.min' => "string", 'email.email' => 'string',
        'phone_no.required' => "string", 'phone_no.min' => "string",
        'notification_type.required' => "string", 'notification_type.min' => "string"
    ])]
    public function messages(): array
    {
        return [
            'name.required' => 'Name must be entered',
            'name.min' => 'Name must be at least 2 characters',
            'email.required' => 'Email must be entered',
            'email.min' => 'Email must be at least 2 characters',
            'phone_no.required' => 'Phone no must be entered',
            'phone_no.min' => 'Phone no must be at least 2 characters',
            'notification_type.required' => 'Notification type must be entered',
            'notification_type.min' => 'Notification type must be at least 2 characters',
        ];
    }
}
