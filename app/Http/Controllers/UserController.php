<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\NewAccessToken;



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
        $token = $user->createToken('login');


        return ['token' => $token->plainTextToken];
    }



}
