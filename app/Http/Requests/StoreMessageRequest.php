<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'chat_id' => 'required|exists:chats,id',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,png,gif,mp4|max:20480',
        ];
    }
}
