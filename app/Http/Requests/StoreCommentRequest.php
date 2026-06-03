<?php

namespace App\Http\Requests;

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
            'body.required' => __('messages.comment_required'),
            'body.max' => __('messages.comment_max_500'),
        ];
    }
}
