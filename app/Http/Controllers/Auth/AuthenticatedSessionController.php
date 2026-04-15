<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // Verificamos si el usuario que acaba de loguearse está activo
        if (!$request->user()->activo) {
            Auth::guard('web')->logout(); // Lo sacamos del sistema
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Lanzamos el error de vuelta al formulario de login
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => 'Tu cuenta ha sido deshabilitada. Contacta con el administrador.',
            ]);
        }

        $request->session()->regenerate();
        $user = $request->user();

        // Redirección según el role_id
        if ($user->role_id === 1) { 
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        return redirect()->intended(route('tickets.index', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
