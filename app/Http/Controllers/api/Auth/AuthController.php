<?php

namespace App\Http\Controllers\api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $user = new User([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $user->save();

        $token = $user->createToken($fields['email'])->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {

        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user['password'])) {
            return response([
                'error' => 'Not found user'
            ], 401);
        }

        $token = $user->createToken($fields['email'])->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'Logget out',
        ];
    }

    public function createNewToken(Request $request)
    {
        $userEmail = $request->user()->email;

        $user = User::where('email', $userEmail)->first();
        $user->tokens()->delete();

        $token = $user->createToken($userEmail)->plainTextToken;

        $response = [
            'message' => 'new token has been created',
            'token' => $token,
        ];

        return response($response, 200);
    }
}
