<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

// RoleController.php
class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|string' // Aceita como string
        ]);
        
        try {
            Role::create([
                'name' => $request->name,
                'permissions' => $request->permissions ? json_encode($request->permissions) : null,
            ]);

            return redirect()->route('roles.create')->with('success', 'Tipo de usuário criado com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao criar o tipo de usuário: ' . $e->getMessage());
        }
    }

    // Métodos para editar e excluir roles...
}
