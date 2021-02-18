<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller
{
    /**
     * request: Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|min:3|max:30',
            'lastName' => 'required|string|min:3|max:30',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6|max:30|confirmed',
            'password_confirmation' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = new User();
        $user->first_name = $request->firstName;
        $user->last_name = $request->lastName;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'User';
        $user->save();

        return response()->json([
            'message' => 'User successfully registered',
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            "data" => [
                'accessToken' => $token,
                'tokenType' => 'bearer',
                'expiresIn' => auth()->factory()->getTTL() * 60,
                'user' => auth()->user()
            ]
        ]);
    }
}
