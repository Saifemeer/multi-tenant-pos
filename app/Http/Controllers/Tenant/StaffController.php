<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    // ✅ Sirf admin/manager access kar sakte hain
   protected function authorizeManager()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Only the business admin can manage staff.');
        }
    }

    public function index()
    {
        $this->authorizeManager();

        $tenant = Auth::user()->tenant;

        $staff = User::where('tenant_id', $tenant->id)
            ->orderByRaw("FIELD(role, 'admin', 'manager', 'cashier')")
            ->get();

        return view('tenant.staff.index', compact('staff', 'tenant'));
    }

    public function store(Request $request)
    {
        $this->authorizeManager();

        $tenant = Auth::user()->tenant;

        // ✅ Plan-based staff limit check (Starter plan = koi staff nahi)
        if ($tenant->hasReachedUserLimit()) {
            $message = $tenant->userLimit() === 1
                ? 'Aapki "Starter" plan mein staff add karne ki suhulat nahi hai. Business ya Enterprise plan mein upgrade karein.'
                : 'Aapki plan mein staff limit ' . $tenant->userLimit() . ' hai, jo pahunch chuki hai.';

            return back()->with('error', $message);
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:manager,cashier',
        ]);

        User::create([
            'tenant_id' => $tenant->id,
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'is_active' => true,
        ]);

        return back()->with('success', 'Staff member successfully add ho gaya!');
    }

    public function toggleStatus(User $user)
    {
        $this->authorizeManager();

        // ✅ Sirf apne tenant ka staff modify kar sakte ho
        if ($user->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        // ✅ Khud ko ya kisi admin ko deactivate na kar sako
        if ($user->id === Auth::id() || $user->role === 'admin') {
            return back()->with('error', 'Ye action allowed nahi hai.');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Staff member {$status} ho gaya.");
    }

    public function destroy(User $user)
    {
        $this->authorizeManager();

        if ($user->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        if ($user->id === Auth::id() || $user->role === 'admin') {
            return back()->with('error', 'Ye action allowed nahi hai.');
        }

        $user->delete();

        return back()->with('success', 'Staff member remove kar diya gaya.');
    }
}