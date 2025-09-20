<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    // loginUserDetails
    public function loginUserDetails(Request $request)
    {
        return response()->json($request->user());
    }

    // Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:20',
            'email' => 'required|string|email|max:25|unique:users',
            'phone' => 'required|string|max:15|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $otp = rand(10000, 99999);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'otp' => $otp,
        ]);

        // send OTP via email or SMS here

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'user_name' => $user->name,
            'message' => 'Registration successful. Please verify your email/phone with OTP sent.',
        ], 201);
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);


        // $request->login can be email or phone check first
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        // if $loginType is phone, find user by phone
        if ($loginType === 'phone') {
            $user = User::where('phone', $request->login)
                ->where('role', 'user')
                ->whereNull('otp')
                ->first();
        }else{
            $user = User::where('email', $request->login)
                ->where('role', 'user')
                ->whereNull('otp')
                ->first();
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);

        return redirect()->route('home');
    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    // Profile
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }
}
