<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;

// 🔹 Hanya untuk tamu (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // 🔹 Lupa Password
    Route::get('/password/reset', function () {
        return view('auth.passwords.email');
    })->name('password.request');

    Route::post('/password/email', function (\Illuminate\Http\Request $request) {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $status = \Illuminate\Support\Facades\Password::sendResetLink($request->only('email'));
        return $status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    })->name('password.email');

    Route::get('/password/reset/{token}', function ($token) {
        return view('auth.passwords.reset', ['token' => $token]);
    })->name('password.reset');

    Route::post('/password/reset', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);
        $status = \Illuminate\Support\Facades\Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = \Illuminate\Support\Facades\Hash::make($password);
                $user->save();
            }
        );
        return $status === \Illuminate\Support\Facades\Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    })->name('password.update');
});

// 🔹 Logout → BISA DIAKSES SIAPA SAJA (tapi hanya berfungsi jika sudah login)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 🔹 Hanya untuk user yang sudah login
Route::middleware('auth')->group(function () {
    // Redirect root ke dashboard
    Route::get('/', function () {
        return redirect('/dashboard');
    });

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/search', [DashboardController::class, 'search'])->name('dashboard.search');
    Route::get('/dashboard/report/pdf', [DashboardController::class, 'generateReportPDF'])->name('dashboard.report.pdf');

    // Admin Only
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);

    // Admin & Staff
    Route::resource('stock-in', StockInController::class);
    Route::resource('stock-out', StockOutController::class);
});