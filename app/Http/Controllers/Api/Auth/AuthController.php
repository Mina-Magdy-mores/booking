<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        //    $validated = $request->validate([
        //         'name' => 'required|string|max:255',
        //         'email' => 'required|email|unique:users,email',
        //         'password' => 'required|min:8|confirmed',
        //         "password_confirmation" => "required|min:8",
        //         'role' => 'in:admin,user'
        //     ]);

        //     return response()->json([
        //         'message' => 'Successfully registered',
        //         'data' => $validated
        //     ], 201);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            "password_confirmation" => "required|min:8",
            'role' => 'in:admin,user'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }
        $hashPassword = Hash::make($request->password);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $hashPassword,
            'role' => $request->role ?? "user"
        ]);
        if (!$user) {
            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }
        $token = $user->createToken('ApiToken')->plainTextToken;
        return response()->json([
            'message' => 'Successfully registered',
            'data' => $user,
            'token' => $token
        ], 201);
    }
    public function login(LoginRequest $request)
    {
        // if(!$user || ! Hash::check($request->password, $user->password)){
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('ApiToken')->plainTextToken;
        return response()->json([
            'message' => 'Successfully logged in',
            'data' => new UserResource($user),
            'token' => $token
        ], 200);
    }
    public function logout(Request $request,)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }
    public function profile(Request $request)
    {
        return response()->json([
            'message' => 'Successfully logged in',
            'data' => new UserResource($request->user())
        ], 200);
    }
}
