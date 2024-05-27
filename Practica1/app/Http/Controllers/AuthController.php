<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['register', 'login']);
    }

    public function register(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|min:2|max:80',
            'lastname_p' => 'required|min:2|max:50',
            'lastname_m' => 'required|min:2|max:50',
            'age' => 'required|numeric',
            'birthdate' => 'required|date',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|min_digits:10|max_digits:10|unique:users,phone',
            'password' => 'required|min:8|confirmed',
            'g-recaptcha-response' => ['required', new \App\Rules\Recaptcha]
        ]);

        if ($validatedData->fails()) {
            return redirect('registrarForm')
                ->withErrors($validatedData)
                ->withInput();
        }

        // Crear el nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'lastname_p' => $request->lastname_p,
            'lastname_m' => $request->lastname_m,
            'age' => $request->age,
            'birthdate' => $request->birthdate,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);
        $user->save();

        // Redireccionar al usuario al login después de registrarse
        return redirect()->route('login')->with('success', 'Registro exitoso. Por favor, revisa tu correo electrónico para activar tu cuenta.');
    }

    public function login(Request $request): Response
    {
        $validatedData = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validatedData->fails()) {
            return redirect('login')
                ->withErrors($validatedData)
                ->withInput();
        }

        $credentials = $validatedData->validated();

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return redirect()->route('login')->with('error', 'Las credenciales que has proporcionado no son correctas.');
            }
        } catch (JWTException $e) {
            Log::info(["JWTException: ", $e]);
            return redirect('login')->with('error', '¡Hay un error!. Contáctate con el admin.');
        }
        return redirect()->route('auth')->withCookie(cookie('token', $token, 60));
    }

    public function logout(): Response
    {
        // Invalidar el token JWT
        Auth::logout();

        // Eliminar la cookie
        $cookie = Cookie::forget('token');

        // Redirigir al usuario a la página de inicio de sesión
        return redirect()->route('principal')->withCookie($cookie);
    }
}
