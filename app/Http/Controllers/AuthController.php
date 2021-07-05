<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserLoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * @Resource("Auth Modules")
 */
class AuthController extends Controller
{
    /**
     * Register user
     *
     * Register a new user with a `username` and `password`.
     */
    public function register(UserCreateRequest $request)
    {
        $user = User::create([
            'name' => $request->get('name'),
            'password' => bcrypt($request->get('password')),
            'email' => $request->get('email')
        ]);

        return $this->success([
            'user' => $user
        ]);
    }

    /**
     * Login
     *
     * Login system using `email` and `password`.

     */
    public function login(UserLoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('Credentials not match', 401);
        }

        return $this->success(null, 'Logged in successfully');
    }

    /**
     * Logout
     *
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return $this->success(null, 'Token Revoked');
    }
}
