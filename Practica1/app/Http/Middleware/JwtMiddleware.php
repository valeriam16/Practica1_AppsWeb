<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
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
            \Log::info('Token JWT extraído de la cookie: ' . $token);
        } else {
            \Log::info('No se encontró token JWT en la cookie.');
        }

        // Intentar autenticar al usuario
        try {
            $user = JWTAuth::parseToken()->authenticate();
            \Log::info('Cookie JWT detectada. Usuario autenticado: ' . $user->getKey());
            return $next($request);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            \Log::info('Excepción TokenExpiredException: ' . $e->getMessage());
            return redirect()->route('login')->withErrors(["message" => "Token expirado"]);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            \Log::info('Excepción TokenInvalidException: ' . $e->getMessage());
            return redirect()->route('login')->withErrors(["message" => "Token inválido"]);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            \Log::info('Excepción JWTException: ' . $e->getMessage());
            return redirect()->route('login')->withErrors(["message" => "Token ausente"]);
        } catch (\Exception $e) {
            \Log::info('Excepción general: ' . $e->getMessage());
            return redirect()->route('login')->withErrors(["message" => "Acceso no autorizado"]);
        }

        return $next($request);
    }
}
