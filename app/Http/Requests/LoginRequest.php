<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\LoginRequest;

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
            'email.required' => 'Էլ. հասցեն պարտադիր է մուտքի համար։',
            'email.email' => 'Խնդրում ենք ներմուծել վավեր էլ. հասցե։',
            'password.required' => 'Գաղտնաբառը պարտադիր է։',
        ];
    }
}
