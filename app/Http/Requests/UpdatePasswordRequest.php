<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Ընթացիկ գաղտնաբառը պարտադիր է:',
            'new_password.required' => 'Նոր գաղտնաբառը պարտադիր է:',
            'new_password.min' => 'Նոր գաղտնաբառը պետք է լինի առնվազն 8 նիշ:',
            'new_password.confirmed' => 'Գաղտնաբառի հաստատումը չի համընկնում:',
        ];
    }
}
