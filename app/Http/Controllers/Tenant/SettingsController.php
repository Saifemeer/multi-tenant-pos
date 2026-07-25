<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    /**
     * Display tenant settings.
     */
    public function index()
    {
        return view('tenant.settings.index');
    }

    /**
     * Update current business settings.
     */
    public function update(Request $request)
    {
        $tenant = auth()->user()->tenant;

        $validated = $request->validate([
            'company_name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('tenants', 'email')->ignore($tenant->id),
            ],
            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],
            'address' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'currency' => [
                'required',
                Rule::in(['PKR', 'USD', 'AED']),
            ],
        ]);

        $tenant->update($validated);

        return back()->with('success', 'Business settings updated successfully.');
    }

    /**
     * Update the logged-in user's profile.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
            ],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Permanently delete the current tenant and all related data.
     */
    public function destroy(Request $request)
    {
        $user = auth()->user();

        if (!in_array($user->role, ['admin', 'super_admin'], true)) {
            abort(403, 'Only a business administrator can delete this account.');
        }

        $tenantId = $user->tenant_id;

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Tenant::findOrFail($tenantId)->delete();

        return redirect()
            ->route('business.register')
            ->with('success', 'The business account has been deleted.');
    }
}