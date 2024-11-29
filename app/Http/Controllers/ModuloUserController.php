<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\User;
use App\Models\ModuloUser;
use Illuminate\Http\Request;

class ModuloUserController extends Controller
{
    // Exibe os usuários e módulos com permissões
    public function index()
    {
        $modulos = Modulo::all();
        $users = User::all();
        $moduloUsers = ModuloUser::all();
        return view('modulo_user.index', compact('modulos', 'users', 'moduloUsers'));
    }

    // Associa um módulo a um usuário com a permissão
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'modulo_id' => 'required|exists:modulos,id',
            'permissao' => 'required|string',
        ]);

        ModuloUser::create($request->all());

        return redirect()->route('modulo_user.index')->with('success', 'Permissão de módulo atribuída com sucesso!');
    }

    // Atualiza a permissão de um usuário para um módulo
    public function update(Request $request, $id)
    {
        $request->validate([
            'permissao' => 'required|string',
        ]);

        $moduloUser = ModuloUser::findOrFail($id);
        $moduloUser->update(['permissao' => $request->permissao]);

        return redirect()->route('modulo_user.index')->with('success', 'Permissão de módulo atualizada com sucesso!');
    }

    // Remove a associação de um módulo de um usuário
    public function destroy($id)
    {
        $moduloUser = ModuloUser::findOrFail($id);
        $moduloUser->delete();

        return redirect()->route('modulo_user.index')->with('success', 'Permissão de módulo removida com sucesso!');
    }
}
