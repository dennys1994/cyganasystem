<?php

// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role; // Certifique-se de que você tem o modelo Role
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
     * Exibe o formulário para criação de um novo usuário.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Obtém todas as roles para poder selecionar o tipo de usuário
        $roles = Role::all();

        return view('admin.create-user', compact('roles'));
    }

    /**
     * Armazena o novo usuário na base de dados.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validação
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed', // Confirmacao de senha
            'role' => 'required|exists:roles,id',
        ]);

        try {
            // Criação do usuário
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']), // Senha criptografada
                'role_id' => $validated['role'], // A relação entre o usuário e o papel
            ]);

            // Sucesso
            return redirect()->route('user.create')->with('success', 'Usuário criado com sucesso!');
        } catch (\Exception $e) {
            // Erro
            return redirect()->route('user.create')->with('error', 'Ocorreu um erro ao criar o usuário. Tente novamente.');
        }
    }


}
