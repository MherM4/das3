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
            'category_id.exists' => __('messages.category_dosent_exists'),
            'search.max' => __('messages.search_max_100'),
        ];
    }
}
