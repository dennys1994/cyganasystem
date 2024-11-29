<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica se o usuário está autenticado e se a role é 'Admin' (id_role == 2)
        if (Auth::check() && Auth::user()->role_id == 1) {
            return $next($request); // Se for admin, permite o acesso
        }

        // Se não for admin, redireciona para uma página de acesso negado ou qualquer outra rota
        return redirect()->route('dashboard')->with('error', 'Acesso restrito.');
    }
}
