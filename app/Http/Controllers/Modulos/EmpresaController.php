<?php

namespace App\Http\Controllers\Modulos;

use App\Http\Controllers\Controller;
use App\Models\Modulos\Empresa;
use App\Models\Modulos\DadosDigisac;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    /*DIGISAC*************************************************************************************************************************************************************************************** */
    public function index_digisac()
    {
        $dados_digisac = DadosDigisac::all();
        return view('Modulos.PixelBot.Digisac.index', compact('dados_digisac'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create_digisac()
    {
        return view('Modulos.PixelBot.Digisac.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_digisac(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        DadosDigisac::create($request->only('token'));

        return redirect()->route('dados-digisac.index')
                         ->with('success', 'Token criado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit_digisac($id)
    {
        $dado = DadosDigisac::findOrFail($id);
        return view('Modulos.PixelBot.Digisac.edit', compact('dado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_digisac(Request $request, $id)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $dado = DadosDigisac::findOrFail($id);
        $dado->update($request->only('token'));

        return redirect()->route('dados-digisac.index')
                         ->with('success', 'Token atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy_digisac($id)
    {
        DadosDigisac::findOrFail($id)->delete();

        return redirect()->route('dados-digisac.index')
                         ->with('success', 'Token excluído com sucesso!');
    }

    /*EMPRESAS*************************************************************************************************************************************************************************************** */
    /**
     * Exibir uma lista de empresas.
     */
    public function index()
    {
        $empresas = Empresa::all();
        return view('Modulos.PixelBot.index', compact('empresas'));
    }

    /**
     * Mostrar o formulário para criar uma nova empresa.
     */
    public function create()
    {
        return view('Modulos.PixelBot.create');
    }

    /**
     * Salvar uma nova empresa no banco de dados.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_milvus' => 'nullable|string',
            'id_digisac' => 'nullable|string',
            'num_max_horas' => 'nullable|integer',
            'id_responsavel_digisac' => 'nullable|string',
            'nome' => 'nullable|string',
        ]);

        Empresa::create($request->all());

        return redirect()->route('empresa.index')->with('success', 'Empresa criada com sucesso!');
    }

    /**
     * Mostrar detalhes de uma empresa específica.
     */
    public function show(Empresa $empresa)
    {
        return view('Modulos.PixelBot.show', compact('empresa'));
    }

    /**
     * Mostrar o formulário para editar uma empresa.
     */
    public function edit(Empresa $empresa)
    {
        return view('Modulos.PixelBot.edit', compact('empresa'));
    }

    /**
     * Atualizar uma empresa no banco de dados.
     */
    public function update(Request $request, Empresa $empresa)
    {
        $request->validate([
            'id_milvus' => 'nullable|string',
            'id_digisac' => 'nullable|string',
            'num_max_horas' => 'nullable|integer',
            'id_responsavel_digisac' => 'nullable|string',
            'nome' => 'nullable|string',
        ]);

        $empresa->update($request->all());

        return redirect()->route('empresa.index')->with('success', 'Empresa atualizada com sucesso!');
    }

    /**
     * Remover uma empresa do banco de dados.
     */
    public function destroy(Empresa $empresa)
    {
        $empresa->delete();

        return redirect()->route('empresa.index')->with('success', 'Empresa excluída com sucesso!');
    }
}
