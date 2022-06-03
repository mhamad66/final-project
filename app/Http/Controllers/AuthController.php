<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class AuthController extends Controller
{
    public function Register(Request $request)
    {
        $fileds = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);
        $user = User::create([
            'name' => $fileds['name'],
            'email' => $fileds['email'],
            'password' => bcrypt($fileds['password'])
        ]);
        $token = $user->createToken('final-token')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }

    public function Login(Request $request)
    {
        $fileds = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $fileds['email'])->first();

        if (!$user || !Hash::check($fileds['password'], $user->password)) {
            return response(['message' => 'bad creds'], 401);
        }
        $token = $user->createToken('final-token')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }

    public function Logout(Request $request)
    {

        auth()->user()->tokens()->delete();
        return ['message' => 'logged out'];
    }
}
