<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\Admin;

class AuthController extends Controller
{
    // Show login form
    public function create()
    {
        return view('admin.auth.login');
    }

    // Handle login
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required',
        ]);

        if ($this->attemptLogin($credentials, $request)) {
            toastr()->success('Login successfully to the Admin panel');
            return redirect()->intended('admin/dashboard');
        }

        toastr()->error('The provided credentials do not match our records.');
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Attempt login with multiple credentials
    private function attemptLogin(array $credentials, Request $request): bool
    {
        return Auth::guard('admin')->attempt($credentials, $request->boolean('remember_me')) ||
            Auth::guard('admin')->attempt(['username' => $credentials['email'], 'password' => $credentials['password']], $request->boolean('remember_me'));
    }

    // Logout admin
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route('admin.login');
    }

    // Show forgot password form
    public function forgotPassword()
    {
        return view('admin.auth.forgot_password');
    }

    // Handle password reset link creation
    public function createPasswordResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:admins,email']);

        $status = Password::broker('admins')->sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            toastr()->success('Password reset link sent to your email');
            return to_route('admin.password-link-sent', ['email' => $request->email]);
        }

        toastr()->error('Password reset link not sent. Please try again.');
        return back()->withErrors(['email' => __($status)]);
    }

    // Show link sent confirmation page
    public function linkSent()
    {
        return view('admin.auth.email_sent');
    }

    // Show reset password form
    public function resetPassword(Request $request)
    {
        $request->validate(['token' => 'required']);
        return view('admin.auth.reset_password', ['token' => $request->token]);
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::broker('admins')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Admin $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            toastr()->success('Password updated successfully');
            return redirect()->route('admin.login')->with('status', __($status));
        }

        toastr()->error('Password update failed. Please try again.');
        return back()->withErrors(['email' => [__($status)]]);
    }
}
