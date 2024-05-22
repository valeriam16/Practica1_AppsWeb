<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AuthController;
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
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth.jwt')->group(function () {
    // Vista auth.blade.php
    Route::get('/auth', function () {
        return view('templates/auth');
    })->name('auth');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

    // PRÁCTICA 2
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    /* Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/');
    })->middleware(['signed'])->name('verification.verify'); */
    /* Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {
        $user = User::find($id);
    
        if ($user && ! $user->hasVerifiedEmail() && hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            $user->markEmailAsVerified();
            event(new Verified($user));
    
            return redirect('/')->with('message', 'Your email has been verified!');
        }
    
        return redirect('/')->with('error', 'Invalid verification link or email already verified.');
    })->middleware(['signed'])->name('verification.verify'); */
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware(['throttle:6,1'])->name('verification.send');