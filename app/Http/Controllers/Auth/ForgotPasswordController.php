<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

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

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = ceil($seconds / 60);

            return back()->withErrors([
    'email' => "Too many requests. Please try again in {$minutes} minute(s).",
]);
        }

        RateLimiter::hit($throttleKey, 600); // 10 minute lockout window

        $status = Password::sendResetLink(
            $request->only('email')
        );

      return $status === Password::RESET_LINK_SENT
    ? back()->with('success', 'A password reset link has been sent to your email.')
    : back()->withErrors(['email' => 'No account found with this email.']);
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
    ? redirect()->route('login')->with('success', 'Password reset successfully! Please log in now.')
    : back()->withErrors(['email' => 'This reset link is invalid or has expired.']);
}
}