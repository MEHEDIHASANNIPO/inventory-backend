<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request) {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if(Auth::attempt($credentials, true)) {
            $user = Auth::user();

            $response = [
                'status_code' => 200,
                'status' => 'success',
                'message' => 'Login Successfull!',
                'data' => [
                    'token' => $user->createToken('Mehedi')->plainTextToken,
                    'user' => $user->name
                ]
            ];

            return response()->json($response, 200);
        } else {
            $response = [
                'status_code' => 401,
                'status' => 'error',
                'message' => 'Unauthorized',
                'data' => null
            ];

            return response()->json($response, 401);
        }
    }
}
