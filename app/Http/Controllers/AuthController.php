<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserLoginRequest;
use App\Models\User;
use Dingo\Blueprint\Annotation\Resource;
use Dingo\Blueprint\Annotation\Response;
use Illuminate\Http\Request;
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
     *
     * @Post("/api/auth/register")
     * @Request({"name": "Md Feroj Bepari", "email": "john@doe.com", "password": "secret"})
     * @Response(200, body={"status": "success", "message": "Message (if any)", "data": {"token": "TOKEN"}})
     */
    public function register(UserCreateRequest $request)
    {
        $user = User::create([
            'name' => $request->get('name'),
            'password' => bcrypt($request->get('password')),
            'email' => $request->get('email')
        ]);

        return $this->success([
            'token' => $user->createToken('API Token')->plainTextToken
        ]);
    }

    /**
     * Login
     *
     * Login system using `email` and `password`.
     *
     * @Post("/api/auth/login")
     * @Transaction({
     *      @Request({"email": "fbepari@bemoacademicconsulting.com", "password": "secret"}),
     *      @Response(200, body={"status": "success", "message": "Message (if any)", "data": {"token": "TOKEN"}}),
     *      @Response(401, body={"status": "success", "message": "Credentials not match", "data": null})
     * })
     */
    public function login(UserLoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('Credentials not match', 401);
        }

        return $this->success([
            'token' => auth()->user()->createToken('API Token')->plainTextToken
        ]);
    }

    /**
     * Logout
     *
     * @Post("/api/auth/logout")
     * @Request(headers={"Authorization": "Bearer [TOKEN]"})
     * @Response(200, body={"status": "success", "message": "Token Revoked", "data": null})
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return $this->success(null, 'Token Revoked');
    }
}
