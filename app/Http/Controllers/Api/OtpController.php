<?php

namespace App\Http\Controllers\Api;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OtpController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:15'
        ]);

        $otpCode = rand(10000, 99999);
        // check if phone exists in the database
        $find_user = User::where('phone', $request->phone)->first();
        if (!$find_user) {
            return response()->json(['message' => 'Phone number not registered'], 404);
        }

        // update new otp if exists
        $find_user->update(['otp' => $otpCode]);

        // send OTP via SMS here

        // return response
        return response()->json(['message' => 'OTP sent successfully']);


    }

    // Verify OTP
    public function verify(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'code' => 'required|string|digits:5'
        ]);
        // check if phone exists in the database
        $find_user = User::where('phone', $request->phone)->first();
        if (!$find_user) {
            return response()->json(['message' => 'Phone number not registered'], 404);
        }
        // check if otp matches
        if ($find_user->otp != $request->code) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        // clear otp
        $find_user->update(['otp' => null]);

        return response()->json(['message' => 'OTP verified successfully, you can now login']);

    }

    // Delete expired OTPs
    public function destroyExpired()
    {
        $deleted = Otp::where('expired_at', '<', now())->delete();
        return response()->json(['deleted' => $deleted]);
    }
}
