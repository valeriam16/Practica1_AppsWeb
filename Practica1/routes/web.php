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
});
Route::get('/registrarForm', [AuthController::class, 'showRegisterForm']);
Route::post('/registrar', [AuthController::class, 'register']);
#Route::post('/login', [AuthController::class, 'login']);

/* Route::get('/register', 'AuthController@showRegisterForm')->middleware('guest'); // Para invitados
Route::post('/register', 'AuthController@register'); // Para invitados

Route::get('/login', 'AuthController@showLoginForm')->middleware('guest'); // Para invitados
Route::post('/login', 'AuthController@login')->middleware('guest'); // Para invitados

Route::get('/', 'HomeController@index')->middleware('auth'); // Solo para usuarios autenticados */

#Route::get('/', [AuthController::class, 'principal']);
#Route::get('/principal', [HomeController::class, 'index'])->middleware('auth');