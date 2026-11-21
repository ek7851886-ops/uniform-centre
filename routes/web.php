<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomizationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\TrackOrderController;
use Illuminate\Support\Facades\Route;

// ---- Public ----
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/uniforms', [ProductController::class, 'index'])->name('uniforms.index');
Route::get('/uniforms/{slug}', [ProductController::class, 'show'])->name('uniforms.show');
Route::get('/our-work', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/customization', [CustomizationController::class, 'index'])->name('customization.index');
Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
Route::get('/track-order', [TrackOrderController::class, 'index'])->name('orders.track');
Route::post('/track-order', [TrackOrderController::class, 'track'])->name('orders.track.post');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/request-quote', [QuotationController::class, 'create'])->name('quotations.create');
Route::post('/request-quote', [QuotationController::class, 'store'])->name('quotations.store');
Route::get('/request-quote/success/{quotation}', [QuotationController::class, 'success'])->name('quotations.success');

// ---- Guest-only auth ----
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---- Authenticated customer area ----
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-quotations', [QuotationController::class, 'myIndex'])->name('quotations.index');
    Route::get('/my-quotations/{quotation}', [QuotationController::class, 'show'])->name('quotations.show');
    Route::post('/my-quotations/{quotation}/approve', [QuotationController::class, 'approve'])->name('quotations.approve');
    Route::post('/my-quotations/{quotation}/reject', [QuotationController::class, 'reject'])->name('quotations.reject');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/my-orders', [OrderController::class, 'index'])->name('my-orders.index');
    Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('my-orders.show');
});

// ---- Admin area (protected by auth + admin middleware) ----
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/quotations', [\App\Http\Controllers\Admin\QuotationController::class, 'index'])->name('quotations.index');
    Route::get('/quotations/{quotation}', [\App\Http\Controllers\Admin\QuotationController::class, 'show'])->name('quotations.show');
    Route::put('/quotations/{quotation}', [\App\Http\Controllers\Admin\QuotationController::class, 'update'])->name('quotations.update');
    Route::post('/quotations/{quotation}/convert-to-order', [\App\Http\Controllers\Admin\QuotationController::class, 'convertToOrder'])->name('quotations.convert');

    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'update'])->name('orders.update');

    Route::get('/products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [\App\Http\Controllers\Admin\ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [\App\Http\Controllers\Admin\ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [\App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/products/{product}/toggle', [\App\Http\Controllers\Admin\ProductController::class, 'toggle'])->name('products.toggle');
    Route::delete('/product-images/{image}', [\App\Http\Controllers\Admin\ProductController::class, 'deleteImage'])->name('products.deleteImage');

    Route::get('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [\App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [\App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/clients', [\App\Http\Controllers\Admin\ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [\App\Http\Controllers\Admin\ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients', [\App\Http\Controllers\Admin\ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{client}/edit', [\App\Http\Controllers\Admin\ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/{client}', [\App\Http\Controllers\Admin\ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{client}', [\App\Http\Controllers\Admin\ClientController::class, 'destroy'])->name('clients.destroy');

    Route::get('/portfolio', [\App\Http\Controllers\Admin\PortfolioController::class, 'index'])->name('portfolio.index');
    Route::get('/portfolio/create', [\App\Http\Controllers\Admin\PortfolioController::class, 'create'])->name('portfolio.create');
    Route::post('/portfolio', [\App\Http\Controllers\Admin\PortfolioController::class, 'store'])->name('portfolio.store');
    Route::get('/portfolio/{portfolio}/edit', [\App\Http\Controllers\Admin\PortfolioController::class, 'edit'])->name('portfolio.edit');
    Route::put('/portfolio/{portfolio}', [\App\Http\Controllers\Admin\PortfolioController::class, 'update'])->name('portfolio.update');
    Route::delete('/portfolio/{portfolio}', [\App\Http\Controllers\Admin\PortfolioController::class, 'destroy'])->name('portfolio.destroy');

    Route::get('/messages', [\App\Http\Controllers\Admin\MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages/{message}/read', [\App\Http\Controllers\Admin\MessageController::class, 'markRead'])->name('messages.read');

    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
});
