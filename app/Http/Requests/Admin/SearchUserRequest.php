<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SearchUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'search.max' => 'Փնտրվող տեքստը չի կարող գերազանցել 100 նիշը:',
        ];
    }
}
