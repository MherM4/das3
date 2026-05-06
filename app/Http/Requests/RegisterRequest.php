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
            'name.required' => 'Անունը պարտադիր է։',
            'email.required' => 'Էլ. հասցեն պարտադիր է։',
            'email.unique' => 'Այս էլ. հասցեն արդեն գրանցված է։',
            'password.required' => 'Գաղտնաբառը պարտադիր է։',
            'password.min' => 'Գաղտնաբառը պետք է լինի առնվազն 8 նիշ։',
            'password.confirmed' => 'Գաղտնաբառի հաստատումը չի համընկնում։',
        ];
    }
}
