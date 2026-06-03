<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('messages.name_required'),
            'email.required' => __('messages.email_required'),
            'email.unique' => __('messages.email_unique'),
            'password.required' => __('messages.password_required'),
            'password.min' => __('messages.password_min_8'),
            'password.confirmed' => __('messages.password_isnt_confirmed'),
        ];
    }
}
