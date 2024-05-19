<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['register', 'login']);
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
            'active' => true,
        ]);
        $user->save();

        // Redireccionar al usuario a la página de app (principal)
        return redirect()->route('principal');
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
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): Response
    {
        // Invalidar el token JWT
        auth()->logout();

        /* // Eliminar la cookie
        $cookie = Cookie::forget('jwt'); */

        // Redirigir al usuario a la página de inicio de sesión
        return redirect()->route('principal')->withCookie('jwt');

        // return response()->json(['message' => 'Successfully logged out']);
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
}