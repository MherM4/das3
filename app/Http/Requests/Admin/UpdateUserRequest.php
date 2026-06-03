<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')->id;

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$userId,
            'password' => 'nullable|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('messages.name_required'),
            'email.required' => __('messages.email_required'),
            'email.unique' => __('messages.email_unique'),
            'password.min' => __('messages.password_min_8'),
        ];
    }
}
