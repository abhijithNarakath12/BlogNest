<?php

namespace App\Http\Requests;

use App\Http\Requests\CustomRequest;

class AuthLoginRequest extends CustomRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|max:255|exists:users',
            'password' => 'required'
        ];
    }
}
