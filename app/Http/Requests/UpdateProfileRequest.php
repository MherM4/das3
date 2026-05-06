<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:8048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Անունը պարտադիր է:',
            'email.required' => 'Էլ. հասցեն պարտադիր է:',
            'email.unique' => 'Այս էլ. հասցեն արդեն զբաղված է:',
            'avatar.image' => 'Ֆայլը պետք է լինի նկար:',
            'avatar.max' => 'Նկարի առավելագույն չափը 8ՄԲ է:',
        ];
    }
}
