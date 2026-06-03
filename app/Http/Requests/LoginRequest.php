<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => __('messages.email_required'),
            'email.email' => __('messages.pls_valid_email'),
            'password.required' => __('messages.password_required'),
        ];
    }
}
