<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterPostRequest extends FormRequest
{
    public function authorize(): bool
    {

        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'nullable|integer|exists:categories,id',
            'search' => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.exists' => 'Ընտրված կատեգորիան գոյություն չունի:',
            'search.max' => 'Փնտրվող տեքստը չափազանց երկար է (առավելագույնը 100 նիշ):',
        ];
    }
}
