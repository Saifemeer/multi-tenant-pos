<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // User deactivate ho gaya ho beech mein
            if (!$user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')
                    ->withErrors(['email' => 'Aapka account deactivate kar diya gaya hai.']);
            }

            // Tenant deactivate ho gaya ho beech mein
            if (!$user->tenant || !$user->tenant->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')
                    ->withErrors(['email' => 'Business account currently active nahi hai.']);
            }
        }

        return $next($request);
    }
}