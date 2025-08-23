<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // middleware already ensures admin
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => [
                'required',
                'email:rfc',
                'regex:/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,}$/',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'string',
                'min:6',
            ],
            'role'=> 'required|in:admin,engineer,tech_lead',
        ];
    }
}
