<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QrLinkController;
use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/go/{slug}', [RedirectController::class, 'handle'])->name('qr.redirect');

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return view('landing');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', HomeController::class)->name('dashboard');
    Route::get('/qr-links/create', [QrLinkController::class, 'create'])->name('qr-links.create');
    Route::post('/qr-links', [QrLinkController::class, 'store'])->name('qr-links.store');
    Route::get('/qr-links/{qrLink}/edit', [QrLinkController::class, 'edit'])->name('qr-links.edit');
    Route::put('/qr-links/{qrLink}', [QrLinkController::class, 'update'])->name('qr-links.update');
    Route::delete('/qr-links/{qrLink}', [QrLinkController::class, 'destroy'])->name('qr-links.destroy');
});
