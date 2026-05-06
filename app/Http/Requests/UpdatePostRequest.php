<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Վերնագիրը պարտադիր է:',
            'category_id.required' => 'Խնդրում ենք ընտրել կատեգորիան:',
            'images.*.image' => 'Ֆայլը պետք է լինի նկար:',
        ];
    }
}
