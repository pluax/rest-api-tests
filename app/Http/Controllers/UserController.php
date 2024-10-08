<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class UserController extends Controller
{

    public function login(LoginRequest $request)
    {
        $email = $request->input('login');
        $password = $request->input('password');
        if (! Auth::guard('web')->attempt(['email' => $email, 'password' => $password])) {
            return response()->json([
                'message' => 'Неверный логин или пароль',
            ], 401);
        }
        $user = Auth('web')->user();
        $token = Str::random(50);

        $user->update(
            ['api_token' => $token ],
        );
        return ['token' => $token];
    }



}
