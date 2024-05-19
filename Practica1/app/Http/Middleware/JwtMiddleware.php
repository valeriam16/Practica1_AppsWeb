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
        }

        // Intentar autenticar al usuario
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return redirect()->route('principal')->withErrors(["message" => "Token expirado"]);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return redirect()->route('principal')->withErrors(["message" => "Token inválido"]);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return redirect()->route('principal')->withErrors(["message" => "Token ausente"]);
        } catch (\Exception $e) {
            return redirect()->route('principal')->withErrors(["message" => "Acceso no autorizado"]);
        }

        return $next($request);
    }
}