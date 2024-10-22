<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    
    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users',
            'password' => 'required|confirmed'
        ]);

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

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|max:255|exists:users',
            'password' => 'required'
        ]);

        $user = User::where("email", $request->email)->first();

        if ($user && !Hash::check($request->password, $user->password)) {
            return [
                'status'=>false,
                'errors' => [
                    'message' => ['The provided credentials are incorrect.']
                ]
            ];
        }
        // dd($user);

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
