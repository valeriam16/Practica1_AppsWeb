<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Auth\Events\Verified;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// PRÁCTICA 1
Route::middleware('guest.jwt')->group(function () {
    // Vista app.blade.php
    Route::get('/', function () {
        return view('templates/noauth');
    })->name('principal');

    // Vista register.blade.php
    Route::get('/registrarForm', function () {
        return view('templates/register');
    });

    // Vista login.blade.php
    Route::get('/loginForm', function () {
        return view('templates/login');
    })->name('login');

    // Métodos de lógica
    Route::post('/registrar', [AuthController::class, 'register']);
});

Route::post('/login', [AuthController::class, 'login'])->middleware(['guest.jwt', 'checkstatus']); // Aplicar ambos middlewares a la ruta de login

Route::middleware('auth.jwt')->group(function () {
    // Vista auth.blade.php
    Route::get('/auth', function () {
        return view('templates/auth');
    })->name('auth');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/read', [UsersController::class, 'read'])->name('read');
    Route::get('/edit', [UsersController::class, 'edit'])->name('edit'); //cambiar esta ruta a get
    Route::post('/update', [UsersController::class, 'update'])->name('update');
});

    // PRÁCTICA 2
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware(['throttle:6,1'])->name('verification.send');
