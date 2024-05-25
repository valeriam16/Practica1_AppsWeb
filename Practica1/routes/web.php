<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
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
    // Vista noauth.blade.php
    Route::get('/', function () {
        return view('templates/noauth');
    })->name('principal');

    // Vista register.blade.php
    Route::get('/registrarForm', function () {
        return view('templates/register');
    })->name('registrarForm');

    // Vista login.blade.php
    Route::get('/loginForm', function () {
        return view('templates/login');
    })->name('login');

    // Métodos de lógica
    Route::post('/registrar', [AuthController::class, 'register'])->name('registrar');
    //Route::post('/login', [AuthController::class, 'login']);
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
