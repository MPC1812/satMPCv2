<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (!Auth::user()->activo) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Tu cuenta ha sido desactivada. Contacta con el administrador.');
            }

            if (Auth::user()->role_id === 1) {
                return $next($request);
            }
        }
        return redirect()->route('tickets.index');
    }
}
