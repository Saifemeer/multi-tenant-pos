<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\TenantRegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Tenant\CategoryController;
use App\Http\Controllers\Tenant\CustomerController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\OrderController;
use App\Http\Controllers\Tenant\ProductController;
use App\Http\Controllers\Tenant\ReportController;
use App\Http\Controllers\Tenant\SettingsController;
use App\Http\Controllers\Tenant\StaffController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\TenantController as SuperAdminTenantController;

// ============================================
// LANDING PAGE
// ============================================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ============================================
// SUBSCRIPTION (Stripe redirect URLs)
// ============================================
Route::get('/subscription/success', [SubscriptionController::class, 'success'])
    ->name('subscription.success');

Route::get('/subscription/cancel', [SubscriptionController::class, 'cancel'])
    ->name('subscription.cancel');

// ============================================
// STRIPE WEBHOOK (CSRF excluded — see bootstrap/app.php)
// ============================================
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle'])
    ->name('stripe.webhook');

// ============================================
// AUTH ROUTES (Sirf Guest ke liye)
// ============================================
Route::middleware('guest')->group(function () {

    Route::get('/register-business', [TenantRegisterController::class, 'showRegisterForm'])
        ->name('business.register');

    Route::post('/register-business', [TenantRegisterController::class, 'register'])
        ->name('business.register.submit');

    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.submit');
});

// Logout (Auth required)
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ============================================
// TENANT ROUTES (Auth Required + Tenant Active Check)
// ============================================
Route::middleware(['auth', 'tenant.active'])->prefix('tenant')->name('tenant.')->group(function () {

    // ─── Sab roles access kar sakte hain (Admin/Manager/Cashier) ───
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/pos', [ProductController::class, 'posScreen'])
        ->name('pos');

    Route::post('/pos/checkout', [ProductController::class, 'checkout'])
        ->name('pos.checkout');

    // ─── Sirf Admin/Manager access kar sakte hain ───────────────────
    Route::middleware('not.cashier')->group(function () {

        // Products
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::post('/products/{product}/stock', [ProductController::class, 'adjustStock'])->name('products.stock');

        // Categories
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Orders
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

        // Customers
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');

        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

        // Settings
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');
        Route::delete('/settings', [SettingsController::class, 'destroy'])->name('settings.destroy');

        // Staff
        Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
        Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
        Route::patch('/staff/{user}/toggle-status', [StaffController::class, 'toggleStatus'])->name('staff.toggle-status');
        Route::delete('/staff/{user}', [StaffController::class, 'destroy'])->name('staff.destroy');
    });

});

// ============================================
// SUPER ADMIN ROUTES (Auth + Super Admin Only)
// ============================================
Route::middleware(['auth', 'super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {

    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/tenants', [SuperAdminTenantController::class, 'index'])
        ->name('tenants.index');

    Route::get('/tenants/{tenant}', [SuperAdminTenantController::class, 'show'])
        ->name('tenants.show');

    Route::patch('/tenants/{tenant}/toggle-status', [SuperAdminTenantController::class, 'toggleStatus'])
        ->name('tenants.toggle-status');

    Route::delete('/tenants/{tenant}', [SuperAdminTenantController::class, 'destroy'])
        ->name('tenants.destroy');
});