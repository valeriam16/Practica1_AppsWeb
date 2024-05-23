<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;


class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            //Log::info('Cookie JWT detectada. Usuario autenticado: ' . $user->getKey());
        } catch (\Exception $e) {
            //Log::info('Excepción general: ' . $e->getMessage());
            return redirect()->route('login')->withErrors(["message" => "Necesitas iniciar sesión."]);
        }
        return $next($request);
    }
}
