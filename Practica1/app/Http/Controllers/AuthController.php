<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Verified;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['register', 'login', 'logout', 'verifyEmail']);
    }

    public function register(Request $request)
    {
        #dd($request->all());
        $validatedData = $request->validate([
            'name' => 'required|min:2|max:80',
            'lastname_p' => 'required|min:2|max:50',
            'lastname_m' => 'required|min:2|max:50',
            'age' => 'required|numeric',
            'birthdate' => 'required|date',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|min_digits:10|max_digits:10|unique:users,phone',
            'password' => 'required|min:8|confirmed',
            'g-recaptcha-response' => ['required', new \App\Rules\Recaptcha],
        ]);

        // Crear el nuevo usuario
        $user = User::create([
            'name' => $validatedData['name'],
            'lastname_p' => $validatedData['lastname_p'],
            'lastname_m' => $validatedData['lastname_m'],
            'age' => $validatedData['age'],
            'birthdate' => $validatedData['birthdate'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'password' => Hash::make($validatedData['password']),
        ]);
        $user->save();

        Log::info("User", [$user]);
        // Envia correo de verificación
        $user->sendEmailVerificationNotification();
        Log::info("Email Enviado");

        // Redireccionar al usuario a la página de verificación de email
        return redirect()->route('login')->with('success', 'Registro exitoso. Termina de activar tu cuenta dando click al enlace que te mandamos por correo electrónico.');
    }

    public function login(Request $request): Response
    {
        // Validar que email sea required|email y que password sea required|min:8
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $credentials = ['email' => $validatedData['email'], 'password' => $validatedData['password']];

        // Generar el tokenJWT
        if (!$token = auth()->attempt($credentials)) {
            // En caso de error, redirigir al propio login con un mensaje de error 'Unauthorized'
            return redirect()->route('login')->with('error', 'Las credenciales que has proporcionado no son correctas.');
        }

        // Crear una cookie con el token JWT
        $cookie = cookie('jwt', $token, 60);  // La cookie expira en 60 minutos

        // En caso de exito, retornar a una ruta 'principal' con la cookie recién creada
        return redirect()->route('auth')->withCookie($cookie);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = auth()->user();
        \Log::info('User', $user);
        return view('templates.auth', compact('user')); // Asumiendo que 'auth' es el nombre de tu vista
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function logout(): Response
    {
        \Log::info('Entrando al método logout del controlador AuthController.');

        // Registrar que estamos intentando cerrar sesión
        \Log::info('Intentando cerrar sesión.');

        // Invalidar el token JWT
        Auth::logout();

        // Registrar que el token fue invalidado
        \Log::info('Token JWT invalidado.');

        // Eliminar la cookie
        $cookie = Cookie::forget('jwt');

        // Registrar que la cookie fue eliminada
        \Log::info('Cookie JWT eliminada.');

        // Redirigir al usuario a la página de inicio de sesión
        return redirect()->route('principal')->withCookie($cookie);
    }



    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    // Práctica 2
    public function verifyEmail($id, $hash)
    {
        $user = User::find($id);

        if ($user && ! $user->hasVerifiedEmail() && hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            $user->markEmailAsVerified();
            $user->active = true;
            $user->save();

            event(new Verified($user));

            return redirect('/')->with('message', 'Your email has been verified!');
        }

        return redirect('/')->with('error', 'Invalid verification link or email already verified.');
    }
}
