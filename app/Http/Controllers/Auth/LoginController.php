<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // Agar already logged in hai toh dashboard pe bhejo
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

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // ✅ Role based redirect
            if ($user->isCashier()) {
                return redirect()->route('tenant.pos')
                    ->with('success', 'Welcome ' . $user->name . '!');
            }

            return redirect()->route('tenant.dashboard')
                ->with('success', 'Welcome back ' . $user->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email ya password galat hai.',
        ])->onlyInput('email');
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