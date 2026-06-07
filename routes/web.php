<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\HamyarAuthController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



Route::prefix('hamyaran')->name('hamyaran.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/register', [HamyarAuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [HamyarAuthController::class, 'register'])->name('register.submit');

        Route::get('/login', [HamyarAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [HamyarAuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [HamyarAuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', [HamyarAuthController::class, 'dashboard'])->name('dashboard');
        Route::get('/pending', [HamyarAuthController::class, 'pending'])->name('pending');

        Route::get('/profile', [HamyarAuthController::class, 'showProfile'])->name('profile');
        Route::post('/profile', [HamyarAuthController::class, 'updateProfile'])->name('profile.update');
    });
});
