<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Exception;

class CheckActiveStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (!User::where('email', $request->input('email'))->first()->active) {
                return redirect()->route('login')->with(["error" => "Tu cuenta no está activa."]);
            }
        } catch (Exception $e) {
        }
        return $next($request);
    }
}
