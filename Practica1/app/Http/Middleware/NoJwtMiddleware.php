<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class NoJwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Extraer el token de la cookie y añadirlo al encabezado 'Authorization'
        if ($token = $request->cookie('jwt')) {
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }

        try {
            // Intenta obtener el usuario autenticado
            $user = JWTAuth::parseToken()->authenticate();

            // Si el usuario está autenticado, redirige a la ruta '/auth'
            return redirect()->route('auth');
        } catch (TokenExpiredException $e) {
            // Si el token ha expirado, cerrar la sesión y redirigir al usuario a la ruta principal
            JWTAuth::invalidate(JWTAuth::getToken());
            return redirect()->route('principal');
        } catch (\Exception $e) {
            // Si ocurre alguna excepción, permite el acceso a la ruta
            //\Log::error('JWT Middleware Error: ' . $e->getMessage());
            return $next($request);
        }
        // Si el usuario está autenticado, redirige a la ruta '/auth'
        return redirect()->route('auth');
    }
}
