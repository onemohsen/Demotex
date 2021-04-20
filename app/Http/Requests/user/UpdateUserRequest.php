<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{


    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'name' => 'required',
            'email' => ['required', Rule::unique('users')->ignore($this->user->id)],
            'is_admin' => ['required', 'boolean']
        ];

    }
}
