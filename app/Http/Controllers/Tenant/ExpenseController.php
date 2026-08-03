<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    protected array $categories = [
        'rent'        => 'Rent',
        'utilities'   => 'Utilities',
        'salaries'    => 'Salaries',
        'supplies'    => 'Supplies',
        'marketing'   => 'Marketing',
        'maintenance' => 'Maintenance',
        'other'       => 'Other',
    ];

    public function index(Request $request)
    {
        $tenant = auth()->user()->tenant;

        $query = Expense::with('user')->latest('expense_date');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('month')) {
            $query->whereMonth('expense_date', \Carbon\Carbon::parse($request->month)->month)
                  ->whereYear('expense_date', \Carbon\Carbon::parse($request->month)->year);
        }

        $expenses = $query->paginate(15)->withQueryString();

        // ✅ Stats
        $thisMonthTotal = Expense::whereMonth('expense_date', now()->month)
            ->whereYear('expense_date', now()->year)
            ->sum('amount');

        $thisWeekTotal = Expense::whereBetween('expense_date', [
            now()->startOfWeek(), now()->endOfWeek(),
        ])->sum('amount');

        $totalAllTime = Expense::sum('amount');

        // ✅ Category breakdown (is month ke liye)
        $categoryBreakdown = Expense::whereMonth('expense_date', now()->month)
            ->whereYear('expense_date', now()->year)
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        return view('tenant.expenses.index', compact(
            'expenses', 'thisMonthTotal', 'thisWeekTotal', 'totalAllTime',
            'categoryBreakdown'
        ) + ['categories' => $this->categories]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'amount'       => 'required|numeric|min:0.01',
            'category'     => 'required|in:' . implode(',', array_keys($this->categories)),
            'description'  => 'nullable|string|max:1000',
            'expense_date' => 'required|date|before_or_equal:today',
            'receipt'      => 'nullable|image|mimes:jpeg,png,jpg,webp,pdf|max:2048',
        ]);

        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')->store('expense-receipts', 'public');
        }

        Expense::create([
            'tenant_id'    => auth()->user()->tenant_id,
            'user_id'      => auth()->id(),
            'title'        => $request->title,
            'amount'       => $request->amount,
            'category'     => $request->category,
            'description'  => $request->description,
            'expense_date' => $request->expense_date,
            'receipt'      => $receiptPath,
        ]);

        return back()->with('success', 'Expense successfully record ho gaya!');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->tenant_id !== auth()->user()->tenant_id) {
            abort(403);
        }

        if ($expense->receipt) {
            Storage::disk('public')->delete($expense->receipt);
        }

        $expense->delete();

        return back()->with('success', 'Expense delete ho gaya.');
    }
}