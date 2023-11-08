<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'role' => "user",
            'password' => bcrypt($fields['password'])
        ]);

        $token =  $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];

        // event(new Registered($user));
        return response($response, 201);
    }
    public function registers(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        $this->guard()->login($user);
        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
    public function logout(Request $request)
    {
        // auth()->user()->tokens()->delete();  with an error
        // $request->user()->currentAccessToken()->delete();  no error
        // $request->user('sanctum')->currentAccessToken()->delete(); no eror

        //  Revoke all tokens...
        // $user->tokens()->delete();

        // Revoke a specific token...
        //$user->tokens()->where('id', $tokenId)->delete();

        // Revoke the token that was used to authenticate the current request...
        $request->user()->currentAccessToken()->delete();


        return [
            'message' => 'Logged out'
        ];
    }
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        // check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }
}
