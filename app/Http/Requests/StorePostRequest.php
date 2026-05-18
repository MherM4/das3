<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => __('messages.title_required'),
            'body.required' => __('messages.body_required'),
            'images.*.image' => __('messages.file_must_be_image'),
            'images.*.max' => __('messages.image_size_5mb'),
            'images.max' => __('messages.images_max_5'),
        ];
    }
}
