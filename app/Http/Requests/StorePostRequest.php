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
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => __('messages.title_required'),
            'body.required' => __('messages.body_required'),
            'category_id.required' => __('messages.category_is_required'),
            'images.*.image' => __('messages.file_must_be_image'),
            'images.*.mimes' => __('messages.file_must_be_image_format'),
            'images.*.max' => __('messages.image_size_5mb'),
            'images.max' => __('messages.images_max_5'),
        ];
    }
}
