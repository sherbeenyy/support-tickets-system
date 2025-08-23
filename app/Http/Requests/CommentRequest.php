<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; //should be only Auth users
    }


    public function rules(): array
    {
        return [
            'ticket_id' => ['required', 'exists:tickets,id'],
            'content'   => ['required', 'string', 'max:300'],
        ];
    }


    public function messages(): array
    {
        return [
            'ticket_id.required' => 'Ticket ID is required.',
            'ticket_id.exists'   => 'The selected ticket does not exist.',
            'content.required'   => 'Please write your comment.',
            'content.max'        => 'Comment cannot be longer than 300 characters.',
        ];
    }
}
