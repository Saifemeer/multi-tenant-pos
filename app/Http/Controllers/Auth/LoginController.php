<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('tenant.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $throttleKey = Str::lower($credentials['email']) . '|' . $request->ip();

        // ✅ Rate limit check — 5 attempts, phir lockout
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = ceil($seconds / 60);

            throw ValidationException::withMessages([
    'email' => "Too many failed attempts. Please try again in {$minutes} minute(s).",
]);
        }

        if (!Auth::attempt($credentials)) {
            // ❌ Galat login — attempt count badhao
            RateLimiter::hit($throttleKey, 300); // 5 minute ka lockout window

            $remaining = 5 - RateLimiter::attempts($throttleKey);

            return back()->withErrors([
    'email' => $remaining > 0
        ? "Incorrect email or password. {$remaining} attempt(s) remaining."
        : 'Too many failed attempts. Please try again in 5 minutes.',
])->onlyInput('email');
        }

        // ✅ Login successful — rate limit clear karo
        RateLimiter::clear($throttleKey);

        $user = Auth::user();

       if (!$user->is_active) {
    Auth::logout();
    return back()->withErrors([
        'email' => 'Your account has been deactivated. Please contact the admin.',
    ])->onlyInput('email');
}

        if (!$user->isSuperAdmin()) {
            $tenant = $user->tenant;
           if (!$tenant || !$tenant->is_active) {
    Auth::logout();
    return back()->withErrors([
        'email' => 'Your business account is currently inactive. Please contact support.',
    ])->onlyInput('email');
}
        }

        $request->session()->regenerate();

        if ($user->isSuperAdmin()) {
            return redirect()->route('super-admin.dashboard')
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        if ($user->isCashier()) {
            return redirect()->route('tenant.pos')
                ->with('success', 'Welcome ' . $user->name . '!');
        }

        return redirect()->route('tenant.dashboard')
            ->with('success', 'Welcome back ' . $user->name . '!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
       return redirect()->route('login')
    ->with('success', 'You have been logged out!');
}
}