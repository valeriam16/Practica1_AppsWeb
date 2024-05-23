<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;

class CheckActiveStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info("He llegado al middleware CheckActiveStatus.");
        try {
            /* $user = JWTAuth::user;
            Log::info('Aquí irá el obj user: ', ['User' => $user]);
            if (!$user->active) {
                Log::info("Estoy dentro del if.");
                return redirect()->route('login')->with(["error" => "Tu cuenta no está activa del midd."]);
            } */
            if (!User::where('email', $request->input('email'))->first()->active) {
                //Log::info("Estoy dentro del if.");
                return redirect()->route('login')->with(["error" => "Tu cuenta no está activa."]);
            }
        } catch (Exception $e) {
            //Log::info('JWTException: ', ['e' => $e->getMessage()]);
        }
        //Log::info("El middleware esta dejando pasar a la siguiente capa.");
        return $next($request);
    }
}
