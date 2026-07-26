<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Email ya password galat hai.',
            ])->onlyInput('email');
        }

        $user = Auth::user();

        // ✅ User active hai ya nahi check karo (sab roles ke liye)
        if (!$user->is_active) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Aapka account deactivate kar diya gaya hai. Admin se contact karein.',
            ])->onlyInput('email');
        }

        // ✅ Super admin ke liye tenant check skip karo
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

        // ✅ Super admin ko super-admin dashboard pe bhejo
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