<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedirectController;


Route::get('/go/{slug}', [RedirectController::class, 'handle'])->name('qr.redirect');
Route::get('/', function () {
    return view('welcome');
});
