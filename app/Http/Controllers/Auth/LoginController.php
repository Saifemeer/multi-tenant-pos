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
                'email' => "Bahut zyada galat attempts ho gaye. Meherbani karke {$minutes} minute baad dubara try karein.",
            ]);
        }

        if (!Auth::attempt($credentials)) {
            // ❌ Galat login — attempt count badhao
            RateLimiter::hit($throttleKey, 300); // 5 minute ka lockout window

            $remaining = 5 - RateLimiter::attempts($throttleKey);

            return back()->withErrors([
                'email' => $remaining > 0
                    ? "Email ya password galat hai. {$remaining} attempts baaki hain."
                    : 'Bahut zyada galat attempts ho gaye. 5 minute baad try karein.',
            ])->onlyInput('email');
        }

        // ✅ Login successful — rate limit clear karo
        RateLimiter::clear($throttleKey);

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Aapka account deactivate kar diya gaya hai. Admin se contact karein.',
            ])->onlyInput('email');
        }

        if (!$user->isSuperAdmin()) {
            $tenant = $user->tenant;
            if (!$tenant || !$tenant->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Aapka business account currently active nahi hai. Support se contact karein.',
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
            ->with('success', 'Aap logout ho gaye hain!');
    }
}