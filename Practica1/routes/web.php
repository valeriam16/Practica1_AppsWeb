<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

Route::middleware('guest.jwt')->group(function () {
    // Vista app.blade.php
    Route::get('/', function () {
        return view('app');
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
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth.jwt')->group(function () {
    // Vista auth.blade.php
    Route::get('/auth', function () {
        return view('templates/auth');
    })->name('auth');

    Route::get('/logout', [AuthController::class, 'logout']);
});
