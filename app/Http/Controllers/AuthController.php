<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthLoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    
    public function register(AuthRegisterRequest $request) {

        $fields = $request->validated();
        $user = User::create($fields);

        $token = $user->createToken($request->name);
        
        return [
            'status'=>true,
            'data' => [
                'userData' => $user,
                'token' => $token->plainTextToken
                ]
            ]; 
    }

    public function login(AuthLoginRequest $request) {
        $user = User::where("email", $request->email)->first();

        if ($user && !Hash::check($request->password, $user->password)) {
            return [
                'status'=>false,
                'errors' => [
                    'message' => ['The provided credentials are incorrect.']
                ]
            ];
        }

        $token = $user->createToken($user->name);

        return [
            'status'=>true,
            'data' => [
                'userData' => $user,
                'token' => $token->plainTextToken
                ]
            ]; 

    }

    public function logout(Request $request) {
        
        $request->user()->tokens()->delete();

        return [
            'status'=>true,
            'data' => [
               'message' => "Logout Successfull"
            ]
        ];
    }

    public function refreshToken(Request $request) {
        
        $request->user()->tokens()->delete();
        $token = $request->user()->createToken($request->user()->name);

        return [
            'status'=>true,
            'data' => [
               'message' => "Refresh Token Successfull",
               'token' => $token->plainTextToken,
            ]
        ];
    }
}
