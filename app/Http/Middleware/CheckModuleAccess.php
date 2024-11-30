<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Modulo; // Modelo da tabela modulos
use App\Models\ModuloUser; // Modelo da tabela user_modulos

class CheckModuleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $module
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $module)
    {
        // Verificar se o usuário está autenticado
        $user = auth()->user();

        // Verificar se o usuário tem o acesso ao módulo usando o nome do módulo
        $hasAccess = ModuloUser::where('user_id', $user->id)
        ->whereHas('modulo', function ($query) use ($module) {
            $query->where('nome', $module);  // Aqui você verifica o nome do módulo
        })
        ->exists();

        if (!$hasAccess) {
            // Redirecionar ou lançar erro caso não tenha permissão
            return redirect()->route('dashboard')->with('error', 'Você não tem permissão para acessar este módulo.');
        }

        return $next($request);
    }
}
