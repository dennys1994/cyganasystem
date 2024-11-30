<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckModuleAccess
{
    public function handle(Request $request, Closure $next, $module)
    {
        $user = Auth::user(); // Obtém o usuário autenticado

        // Verifica se o usuário tem acesso direto ao módulo
        $hasDirectAccess = $user->modules()->where('name', $module)->exists();

        // Verifica se o módulo pertence ao setor/tipo de usuário
        $hasSectorAccess = $user->sector->modules()->where('name', $module)->exists();

        if ($hasDirectAccess || $hasSectorAccess) {
            return $next($request);
        }

        // Caso não tenha permissão, retorna um erro ou redireciona
        return response()->json(['error' => 'Acesso negado ao módulo.'], 403);
    }
}
