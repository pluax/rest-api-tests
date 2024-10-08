<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiRequest;

class LoginRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'login'          => ['required', 'email' ],
            'password'       => ['required'],
        ];
    }
}
