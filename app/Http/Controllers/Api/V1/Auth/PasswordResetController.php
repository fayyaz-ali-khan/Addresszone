<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use App\Models\Otp;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetOtpMail;
use Illuminate\Support\Facades\Hash;

class PasswordResetController
{
    public function sendResetLink(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            Otp::where('email', $request->email)->delete();

            $otp = Str::random(6);

            Otp::create(['email' => $request->email, 'otp' => $otp]);

            $user = User::where('email', $request->email)->first();

            Mail::to($request->email)->send(new PasswordResetOtpMail($otp, $user->name));

            return response()->json(['message' => 'OTP sent successfully.']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong.'], 500);
        }

    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required', 'email' => 'required|email']);

//        ->where('created_at','>=',now()->subMinutes(5))
        $otp = Otp::where('email', $request->email)->where('otp', $request->otp)->first();

        if (!$otp) {
            return response()->json(['message' => 'Invalid OTP.'], 400);
        }

        return response()->json(['message' => 'OTP verified successfully.']);

    }

    public function reset(ResetPasswordRequest $request): JsonResponse
    {
        $otp = Otp::where('email', $request->email)->where('otp', $request->otp)->first();
        if (!$otp) {
            return response()->json(['message' => 'Invalid OTP or OTP expired.'], 400);
        }

        $status = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

        if ($status) {
            Otp::where('email', $request->email)->delete();
        }
        return $status
            ? response()->json(['message' => 'Password reset successfully.'])
            : response()->json(['message' => 'Something went wrong.'], 500);
    }
}
