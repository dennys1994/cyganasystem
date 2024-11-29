<?php

namespace App\Http\Controllers\Margem;

use App\Http\Controllers\Controller;
use App\Models\Margem\CategoriaMargem;
use App\Models\Margem\FaixaPreco;
use Illuminate\Http\Request;

class MargemController extends Controller
{

    public function index()
    {
        return view('modulos.margem.index');
    }


    // Função para exibir o formulário de criação de categorias
    public function createCategoria()
    {
        return view('modulos.margem.create_categoria');
    }

    // Função para salvar a categoria de margem
    public function storeCategoria(Request $request)
    {
        $request->validate([
            'nome' => 'required|unique:categorias_margem',
            'descricao' => 'nullable|string',
        ]);

        CategoriaMargem::create($request->all());

        return redirect()->route('margem.create_categoria')->with('success', 'Categoria criada com sucesso!');
    }

    // Função para exibir o formulário de criação de faixas de preço
    public function createFaixa()
    {
        $tabelas = CategoriaMargem::all();
        return view('modulos.margem.create_faixa', compact('tabelas'));
    }

    // Função para salvar a faixa de preço
    public function storeFaixa(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'categoria_id' => 'required|exists:categorias_margem,id', // Validar tabela de margem
            'min' => 'required|numeric', // Faixa Inicial
            'max' => 'required|numeric', // Faixa Final
            'avista' => 'required|numeric', // Percentual à Vista
            'parcelado' => 'required|numeric', // Percentual Parcelado
        ]);

        FaixaPreco::create($request->all());

        return redirect()->route('margem.create_faixa')->with('success', 'Faixa de preço criada com sucesso!');
    }

    // Função para calcular o preço com base na faixa e na margem
    public function calcularPreco(Request $request)
    {
        $request->validate([
            'faixa_inicial' => 'required|numeric',
            'faixa_final' => 'required|numeric',
            'percentual_margem' => 'required|numeric',
            'preco_base' => 'required|numeric',
        ]);

        $precoBase = $request->preco_base;
        $margem = $request->percentual_margem;

        $precoCalculado = $precoBase + ($precoBase * ($margem / 100));

        return view('margem.calcular_preco', compact('precoCalculado'));
    }
}