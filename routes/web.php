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

// ============================================
// LANDING PAGE
// ============================================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ============================================
// AUTH ROUTES (Sirf Guest ke liye)
// ============================================
Route::middleware('guest')->group(function () {

    // Register
    Route::get('/register-business', [TenantRegisterController::class, 'showRegisterForm'])
        ->name('business.register'); // ✅ 'Form' fix kiya

    Route::post('/register-business', [TenantRegisterController::class, 'register'])
        ->name('business.register.submit'); // ✅ Route:: uppercase fix kiya

    // Login
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
// TENANT ROUTES (Auth Required)
// ============================================
Route::middleware('auth')->prefix('tenant')->name('tenant.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard'); // ✅ Alag DashboardController

    // ─── Products ───────────────────────────
    Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index');

    Route::post('/products', [ProductController::class, 'store'])
        ->name('products.store');

    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
        ->name('products.edit'); // ✅ ADDED

    Route::put('/products/{product}', [ProductController::class, 'update'])
        ->name('products.update'); // ✅ ADDED

    Route::delete('/products/{product}', [ProductController::class, 'destroy'])
        ->name('products.destroy'); // ✅ ADDED

    Route::post('/products/{product}/stock', [ProductController::class, 'adjustStock'])
        ->name('products.stock'); // ✅ ADDED

    // ─── POS Screen ─────────────────────────
    Route::get('/pos', [ProductController::class, 'posScreen'])
        ->name('pos');

    Route::post('/pos/checkout', [ProductController::class, 'checkout'])
        ->name('pos.checkout'); // ✅ name fix kiya

        
    // ✅ Categories
    Route::get('/categories', [App\Http\Controllers\Tenant\CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [App\Http\Controllers\Tenant\CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [App\Http\Controllers\Tenant\CategoryController::class, 'destroy'])->name('categories.destroy');

    // ✅ Orders
    Route::get('/orders', [App\Http\Controllers\Tenant\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\Tenant\OrderController::class, 'show'])->name('orders.show');

    // ✅ Customers
    Route::get('/customers', [App\Http\Controllers\Tenant\CustomerController::class, 'index'])->name('customers.index');
    Route::post('/customers', [App\Http\Controllers\Tenant\CustomerController::class, 'store'])->name('customers.store');

    // ✅ Reports
    Route::get('/reports', [App\Http\Controllers\Tenant\ReportController::class, 'index'])->name('reports.index');

    // ✅ Settings
    Route::get('/settings', [App\Http\Controllers\Tenant\SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [App\Http\Controllers\Tenant\SettingsController::class, 'update'])->name('settings.update');
    Route::put('/settings/profile', [App\Http\Controllers\Tenant\SettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::delete('/settings', [App\Http\Controllers\Tenant\SettingsController::class, 'destroy'])->name('settings.destroy');

});