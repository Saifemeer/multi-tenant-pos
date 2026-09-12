<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display tenant customers.
     */
    public function index(Request $request)
    {
        $query = Customer::withCount('orders');

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $customers = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $totalCustomers = Customer::count();

        $totalCustomerSpending = Customer::sum('total_spent');

        // ✅ Total outstanding credit (udhaar) sab customers ka
        $totalCreditOutstanding = Customer::sum('credit_balance');

        return view('tenant.customers.index', compact(
            'customers',
            'totalCustomers',
            'totalCustomerSpending',
            'totalCreditOutstanding'
        ));
    }

    /**
     * Create a customer for the current tenant.
     */
    public function store(Request $request)
    {
        $tenantId = auth()->user()->tenant_id;

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
            ],
            'phone' => [
                'nullable',
                'string',
                'max:30',
                Rule::unique('customers', 'phone')
                    ->where(fn ($query) => $query->where('tenant_id', $tenantId)),
            ],
            'email' => [
                'nullable',
                'email',
                'max:150',
                Rule::unique('customers', 'email')
                    ->where(fn ($query) => $query->where('tenant_id', $tenantId)),
            ],
            'address' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        Customer::create([
            'tenant_id' => $tenantId,
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'address' => $validated['address'] ?? null,
            'total_spent' => 0,
            'credit_balance' => 0,
            'visit_count' => 0,
            'loyalty_points' => 0,
        ]);

        return back()->with('success', 'Customer added successfully.');
    }

    /**
     * Update an existing customer.
     */
    public function update(Request $request, Customer $customer)
    {
        $tenantId = auth()->user()->tenant_id;

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
            ],
            'phone' => [
                'nullable',
                'string',
                'max:30',
                Rule::unique('customers', 'phone')
                    ->ignore($customer->id)
                    ->where(fn ($query) => $query->where('tenant_id', $tenantId)),
            ],
            'email' => [
                'nullable',
                'email',
                'max:150',
                Rule::unique('customers', 'email')
                    ->ignore($customer->id)
                    ->where(fn ($query) => $query->where('tenant_id', $tenantId)),
            ],
            'address' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $customer->update($validated);

        return back()->with('success', 'Customer updated successfully.');
    }

    /**
     * ✅ Customer ka udhaar (credit) payment record karo.
     */
    public function recordPayment(Request $request, Customer $customer)
    {
        // Sirf apne tenant ka customer modify kar sakte ho
        if ($customer->tenant_id !== auth()->user()->tenant_id) {
            abort(403);
        }

       if ($customer->credit_balance <= 0) {
    return back()->with('error', 'This customer has no outstanding credit.');
}

        $validated = $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:' . $customer->credit_balance,
            ],
        ]);

        $customer->decrement('credit_balance', $validated['amount']);

       return back()->with(
    'success',
    'Payment recorded! New balance: Rs. ' . number_format($customer->fresh()->credit_balance, 2)
);
    }

    /**
     * Delete a customer.
     *
     * Their previous orders will remain available because orders.customer_id
     * should use nullOnDelete/set null.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return back()->with('success', 'Customer deleted successfully.');
    }
}