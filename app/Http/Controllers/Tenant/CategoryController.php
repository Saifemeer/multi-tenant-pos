<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display all categories for the authenticated tenant.
     */
    public function index()
    {
        $categories = Category::withCount('products')
            ->latest()
            ->get();

        return view('tenant.categories.index', compact('categories'));
    }

    /**
     * Store a new category.
     */
    public function store(Request $request)
    {
        $tenantId = auth()->user()->tenant_id;

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories', 'name')
                    ->where(fn ($query) => $query->where('tenant_id', $tenantId)),
            ],
            'color' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],
            'icon' => [
                'nullable',
                'string',
                'max:100',
            ],
        ]);

        Category::create([
            'tenant_id' => $tenantId,
            'name' => $validated['name'],
            'color' => $validated['color'] ?? '#6b7280',
            'icon' => $validated['icon'] ?? null,
            'is_active' => true,
        ]);

        return back()->with('success', 'Category created successfully.');
    }

    /**
     * Delete a category.
     *
     * Products will become uncategorized because category_id
     * uses nullOnDelete/set null in the database.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Category deleted successfully.');
    }
}