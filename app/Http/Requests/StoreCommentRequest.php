<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
 
   public function rules(): array
{
    return [
        'body' => 'required|string|max:500',
    ];
}

public function messages(): array
{
    return [
        'body.required' => 'Մեկնաբանությունը չի կարող դատարկ լինել:',
        'body.max' => 'Մեկնաբանությունը չի կարող անցնել 500 նիշը:',
    ];
}
}
