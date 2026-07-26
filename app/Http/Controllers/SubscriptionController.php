<?php

namespace App\Http\Controllers;

class SubscriptionController extends Controller
{
    public function success()
    {
        return redirect()->route('tenant.dashboard')
            ->with('success', 'Subscription activated! Your 14-day trial has started.');
    }

    public function cancel()
    {
        return redirect()->route('business.register')
            ->with('error', 'Payment was cancelled. Please try again or choose the free Starter plan.');
    }
}