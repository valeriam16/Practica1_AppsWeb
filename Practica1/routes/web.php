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

Route::get('/', function () {
    return view('app');
})->name('principal')->middleware('guest.jwt');
Route::get('/registrarForm', function () {
    return view('templates/register');
})->middleware('guest.jwt');
Route::post('/registrar', [AuthController::class, 'register']);

Route::get('/loginForm', function () {
    return view('templates/login');
})->name('login')->middleware('guest.jwt');
Route::post('/login', [AuthController::class, 'login']);

// AUTH
Route::get('/auth', function () {
    return view('templates/auth');
})->name('auth')->middleware('auth.jwt');
Route::get('/logout', [AuthController::class, 'logout']);



/* Route::get('/register', 'AuthController@showRegisterForm')->middleware('guest'); // Para invitados
Route::post('/register', 'AuthController@register'); // Para invitados

Route::get('/login', 'AuthController@showLoginForm')->middleware('guest'); // Para invitados
Route::post('/login', 'AuthController@login')->middleware('guest'); // Para invitados

Route::get('/', 'HomeController@index')->middleware('auth'); // Solo para usuarios autenticados */

#Route::get('/', [AuthController::class, 'principal']);
#Route::get('/principal', [HomeController::class, 'index'])->middleware('auth');