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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:51020',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Վերնագիրը պարտադիր է:',
            'body.required' => 'Բովանդակությունը պարտադիր է:',
            'images.*.image' => 'Ֆայլը պետք է լինի նկար:',
            'images.*.max' => 'Նկարի չափը չպետք է անցնի 50MB-ը:',
            'images.max' => 'Դուք կարող եք վերբեռնել առավելագույնը 5 նկար:',
        ];
    }
}
