<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user'); //get current user ya basha

        return [
            'name'=> [
                'sometimes', 'string', 'max:255'
            ],
            'email'=> [
                'sometimes',
                'email:rfc',
                'regex:/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,}$/',
                 Rule::unique('users', 'email')->ignore($userId), // ignore current user
            ],
            'password'=> [
                'sometimes', 'string', 'min:6',
            ],
            'role' => [
                'sometimes', 'in:admin,engineer,tech_lead'
            ],
        ];
    }
}
