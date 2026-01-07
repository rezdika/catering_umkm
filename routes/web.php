<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\BerandaController;
use App\Http\Controllers\User\MenuController;
use App\Http\Controllers\User\TentangController;
use App\Http\Controllers\User\KontakController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\FeedbackController;

// Public Routes
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/{menu:slug}', [MenuController::class, 'show'])->name('menu.show');
Route::get('/tentang', [TentangController::class, 'index'])->name('tentang');
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak', [KontakController::class, 'store']);

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google OAuth Routes
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// User Routes
Route::prefix('user')->name('user.')->middleware('auth')->group(function () {
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
    
    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\User\NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{id}/read', [\App\Http\Controllers\User\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::patch('/notifications/read-all', [\App\Http\Controllers\User\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::get('/notifications/count', [\App\Http\Controllers\User\NotificationController::class, 'getUnreadCount'])->name('notifications.count');
    
    // Cart Routes
    Route::get('/cart', [\App\Http\Controllers\User\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [\App\Http\Controllers\User\CartController::class, 'store'])->name('cart.store');
    Route::get('/cart/count', [\App\Http\Controllers\User\CartController::class, 'getCount'])->name('cart.count');
    Route::put('/cart/{cart}', [\App\Http\Controllers\User\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [\App\Http\Controllers\User\CartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/cart', [\App\Http\Controllers\User\CartController::class, 'clear'])->name('cart.clear');
    
    // Order Routes
    Route::get('/orders', [\App\Http\Controllers\User\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [\App\Http\Controllers\User\OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [\App\Http\Controllers\User\OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [\App\Http\Controllers\User\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/cancel', [\App\Http\Controllers\User\OrderController::class, 'cancel'])->name('orders.cancel');
    
    // Payment Routes
    Route::post('/orders/{order}/payment', [\App\Http\Controllers\User\PaymentController::class, 'store'])->name('payment.store');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,staff_dapur,admin_keuangan,kurir'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Categories
    Route::resource('categories', CategoryController::class)->except(['show', 'create', 'edit']);
    
    // Menus
    Route::resource('menus', AdminMenuController::class);
    
    // Users
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    
    // Contacts
    Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::post('contacts/{contact}/reply', [ContactController::class, 'reply'])->name('contacts.reply');
    Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    
    // Feedbacks
    Route::get('feedbacks', [FeedbackController::class, 'index'])->name('feedbacks.index');
    
    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    
    // Profile
    Route::get('profile', [AdminProfileController::class, 'index'])->name('profile.index');
    Route::put('profile', [AdminProfileController::class, 'update'])->name('profile.update');
    
    // Finance Routes (Admin Keuangan)
    Route::prefix('finance')->name('finance.')->middleware('role:admin,admin_keuangan')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\Finance\FinanceDashboardController::class, 'index'])->name('dashboard');
        
        // Payment Verification
        Route::get('/payments', [\App\Http\Controllers\Admin\Finance\PaymentVerificationController::class, 'index'])->name('payments.index');
        Route::get('/payments/create', [\App\Http\Controllers\Admin\Finance\PaymentVerificationController::class, 'create'])->name('payments.create');
        Route::post('/payments', [\App\Http\Controllers\Admin\Finance\PaymentVerificationController::class, 'store'])->name('payments.store');
        Route::get('/payments/{payment}', [\App\Http\Controllers\Admin\Finance\PaymentVerificationController::class, 'show'])->name('payments.show');
        Route::patch('/payments/{payment}/verify', [\App\Http\Controllers\Admin\Finance\PaymentVerificationController::class, 'verify'])->name('payments.verify');
        Route::post('/payments/bulk-verify', [\App\Http\Controllers\Admin\Finance\PaymentVerificationController::class, 'bulkVerify'])->name('payments.bulk-verify');
        Route::get('/payments/{payment}/download-proof', [\App\Http\Controllers\Admin\Finance\PaymentVerificationController::class, 'downloadProof'])->name('payments.download-proof');
        
        // Reports
        Route::get('/reports', [\App\Http\Controllers\Admin\Finance\FinanceReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export', [\App\Http\Controllers\Admin\Finance\FinanceReportController::class, 'export'])->name('reports.export');
    });
    
    // Kitchen Routes (Staff Dapur)
    Route::prefix('kitchen')->name('kitchen.')->middleware('role:admin,staff_dapur')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\Kitchen\KitchenDashboardController::class, 'index'])->name('dashboard');
        
        // Orders Management
        Route::get('/orders/today', [\App\Http\Controllers\Admin\Kitchen\KitchenOrderController::class, 'today'])->name('orders.today');
        Route::get('/orders', [\App\Http\Controllers\Admin\Kitchen\KitchenOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [\App\Http\Controllers\Admin\Kitchen\KitchenOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [\App\Http\Controllers\Admin\Kitchen\KitchenOrderController::class, 'updateStatus'])->name('orders.update-status');
        
        // Reports
        Route::get('/reports', [\App\Http\Controllers\Admin\Kitchen\KitchenReportController::class, 'index'])->name('reports.index');
    });
    
    // Kurir Routes (Kurir)
    Route::prefix('kurir')->name('kurir.')->middleware('role:admin,kurir')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\Kurir\KurirDashboardController::class, 'index'])->name('dashboard');
        
        // Orders Management
        Route::get('/orders', [\App\Http\Controllers\Admin\Kurir\KurirOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [\App\Http\Controllers\Admin\Kurir\KurirOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/take', [\App\Http\Controllers\Admin\Kurir\KurirOrderController::class, 'takeOrder'])->name('orders.take');
        Route::patch('/orders/{order}/complete', [\App\Http\Controllers\Admin\Kurir\KurirOrderController::class, 'completeDelivery'])->name('orders.complete');
        
        // Reports
        Route::get('/reports', [\App\Http\Controllers\Admin\Kurir\KurirReportController::class, 'index'])->name('reports.index');
    });
});

// Profile Routes (Protected)
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::put('/update', [ProfileController::class, 'update'])->name('update');
    Route::get('/orders', [ProfileController::class, 'orders'])->name('orders');
    Route::get('/addresses', [ProfileController::class, 'addresses'])->name('addresses');
    Route::post('/addresses', [ProfileController::class, 'storeAddress'])->name('addresses.store');
    Route::put('/addresses/{id}', [ProfileController::class, 'updateAddress'])->name('addresses.update');
    Route::delete('/addresses/{id}', [ProfileController::class, 'deleteAddress'])->name('addresses.delete');
    Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
    Route::post('/settings', [ProfileController::class, 'updateSettings'])->name('settings.update');
});