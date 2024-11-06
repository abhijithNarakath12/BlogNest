<?php

namespace App\Http\Requests;

use App\Http\Requests\CustomRequest;

class AuthRegisterRequest extends CustomRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users',
            'password' => 'required|confirmed'
        ];
    }
}
