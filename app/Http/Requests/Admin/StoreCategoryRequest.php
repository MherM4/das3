<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\Category;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('create', Category::class);
    }

    public function rules(): array
    {
        return [
            'name_hy' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name_hy.required' => __('messages.name_hy_required'),
            'name_en.required' => __('messages.name_en_required'),
        ];
    }
}
