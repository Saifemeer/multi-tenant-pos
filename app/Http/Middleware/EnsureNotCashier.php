<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureNotCashier
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isCashier()) {
            abort(403, 'Cashiers ko is page tak access nahi hai. Sirf POS Counter use karein.');
        }

        return $next($request);
    }
}