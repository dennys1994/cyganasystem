<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ModuloUser;

class ModuloController extends Controller
{
    // Exibe todos os módulos
    public function index()
    {
        $modulos = Modulo::all();
        return view('Modulos.index', compact('modulos'));  // Ajuste a view conforme necessário
    }

    // Mostra o formulário para criar um novo módulo
    public function create()
    {
        return view('admin.modulos.create');  // Ajuste a view conforme necessário
    }

    // Armazena o novo módulo
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'ativo' => 'required|boolean',
        ]);

        Modulo::create($request->all());

        return redirect()->route('modulos.create')->with('success', 'Módulo criado com sucesso!');
    }


    // Exibe o formulário para editar um módulo
    public function edit($id)
    {
        $modulo = Modulo::findOrFail($id);
        return view('Modulos.edit', compact('modulo'));  // Ajuste a view conforme necessário
    }

    // Atualiza um módulo
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'ativo' => 'required|boolean',
        ]);

        $modulo = Modulo::findOrFail($id);
        $modulo->update($request->all());

        return redirect()->route('modulos.index')->with('success', 'Módulo atualizado com sucesso!');
    }

    // Exclui um módulo
    public function destroy($id)
    {
        $modulo = Modulo::findOrFail($id);
        $modulo->delete();

        return redirect()->route('modulos.index')->with('success', 'Módulo excluído com sucesso!');
    }

     // Exibe a view para atribuir módulos aos usuários
     public function assign()
     {
         $users = User::all();
         $modulos = Modulo::all();
 
         return view('admin.modulos.assign', compact('users', 'modulos'));
     }
 
     // Armazena a atribuição de módulo a um usuário
     public function storeAssignment(Request $request)
     {
         $request->validate([
             'user_id' => 'required|exists:users,id',
             'modulos' => 'required|array',
             'modulos.*' => 'exists:modulos,id',
             'permissao' => 'required|string',
         ]);
 
         foreach ($request->modulos as $moduloId) {
             ModuloUser::create([
                 'user_id' => $request->user_id,
                 'modulo_id' => $moduloId,
                 'permissao' => $request->permissao,
             ]);
         }
 
         return redirect()->route('modulos.assign')->with('success', 'Módulos atribuídos com sucesso!');
     }
}
