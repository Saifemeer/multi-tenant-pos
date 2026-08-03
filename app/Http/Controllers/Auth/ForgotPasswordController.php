<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    // ✅ "Forgot Password" form dikhao
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

   public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $throttleKey = Str::lower($request->email) . '|' . $request->ip();

        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($throttleKey);
            $minutes = ceil($seconds / 60);

            return back()->withErrors([
                'email' => "Bahut zyada requests ho gayi. {$minutes} minute baad dubara try karein.",
            ]);
        }

        \Illuminate\Support\Facades\RateLimiter::hit($throttleKey, 600); // 10 minute lockout window

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Password reset link aapki email pe bhej diya gaya hai.')
            : back()->withErrors(['email' => 'Is email se koi account nahi mila.']);
    }

    // ✅ Reset form dikhao (email se link click karne ke baad)
    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    // ✅ Naya password save karo
    public function reset(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Password successfully reset ho gaya! Ab login karein.')
            : back()->withErrors(['email' => 'Reset link invalid ya expire ho gaya hai.']);
    }
}