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
        return view('Modulos.Financeiro.Margem.index');
    }

    public function index_categorias()
    {
        $categorias = CategoriaMargem::all(); // Obtém todas as categorias do banco
        return view('Modulos.Financeiro.Margem.index_categorias', compact('categorias'));
    }


    // Função para exibir o formulário de criação de categorias
    public function createCategoria()
    {
        return view('Modulos.Financeiro.Margem.create_categoria');
    }

    // Função para salvar a categoria de margem
    public function storeCategoria(Request $request)
    {
        $request->validate([
            'nome' => 'required|unique:categorias_margem',
            'descricao' => 'nullable|string',
            'maodeobra_fixo' => 'required|numeric',
        ]);

        CategoriaMargem::create($request->all());

        return redirect()->route('margem.create_categoria')->with('success', 'Categoria criada com sucesso!');
    }

    // Função para exibir o formulário de criação de faixas de preço
    public function createFaixa()
    {
        $tabelas = CategoriaMargem::all();
        return view('Modulos.Financeiro.Margem.create_faixa', compact('tabelas'));
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
            'categoria_id' => 'required|exists:categorias_margem,id',
            'preco_custo' => 'required|numeric|min:0',
            'frete' => 'required|numeric|min:0',
        ]);
        $categoriaId = $request->categoria_id;
        $custo = $request->preco_custo;
        $frete = $request->frete;

        $faixas = FaixaPreco::where('categoria_id', $categoriaId)->get();
        foreach ($faixas as $faixa) { 
            if ($faixa->min < $custo && $custo <= $faixa->max) {
                $porc_avista = (100-$faixa->avista)/100;
                $porc_parcelado = (100-$faixa->parcelado)/100;
                $categoria = CategoriaMargem::find($categoriaId);
                $maodeobraFixo = $categoria->maodeobra_fixo;

                $avista = ($custo / $porc_avista ) + $frete + $maodeobraFixo;
                

                if ($avista % 10 < 5) {
                    // Se a parte decimal for menor que 0.5, arredonda para a dezena inferior e coloca 9,90 na unidade
                    $avista = floor($avista / 10) * 10 -0.10;  // Arredonda para baixo
                } else {
                    // Se a parte decimal for maior ou igual a 0.5, arredonda para a dezena superior e coloca 9,90 na unidade
                    $avista = ceil($avista/10) * 10 - 0.10;  // Arredonda para cima
                }
                

                $parcelado = ($avista / $porc_parcelado);
                            
                $parcelado = ceil($parcelado/10) * 10 - 0.10;  // Arredonda para cima
                
                $parcelado_cheio = $parcelado;
                $parcelado = $parcelado / 10;

                $margem = $avista - ($frete + $custo) - (0.03 * $avista);
                $margemPorcentagem = ((($custo / ($custo + $margem)) - 1) * -100);
                
                return view('modulos.margem.calcular_preco', [
                    'categorias' => CategoriaMargem::all(),
                    'resultados' => [
                        'custo' => number_format($custo, 2, ',', '.'),
                        'avista' => number_format($avista, 2, ',', '.'),
                        'parcelado' => number_format($parcelado, 2, ',', '.'),
                        'parcelado_cheio' => number_format($parcelado_cheio, 2, ',', '.'),
                        'margem' => number_format($margem, 2, ',', '.'),
                        'margem_percentual' => number_format($margemPorcentagem, 2, ',', '.'),
                    ],
                ]);
            }
        }
        return view('Modulos.Financeiro.Margem.calcular_preco', [
            'categorias' => CategoriaMargem::all(),
            'error' => 'Nenhuma faixa de preço encontrada para os valores informados.',
        ]);
    }


    public function showCalcularPreco()
    {
        $categorias = CategoriaMargem::all(); // Pega todas as categorias
        return view('Modulos.Financeiro.Margem.calcular_preco', compact('categorias'));
    }

    public function edit($id)
    {
        $categoria = CategoriaMargem::findOrFail($id);
        return view('Modulos.Financeiro.Margem.editar_categoria', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'maodeobra_fixo' => 'required|numeric|min:0',
        ]);

        $categoria = CategoriaMargem::findOrFail($id);
        $categoria->update([
            'nome' => $request->nome,
            'maodeobra_fixo' => $request->maodeobra_fixo,
        ]);

        return redirect()->route('margem.categorias.editar', $id)
                        ->with('success', 'Categoria atualizada com sucesso!');
    }

    public function faixas_index()
    {
        $faixas = FaixaPreco::all(); // Obtém todas as faixas de preço do banco
        return view('Modulos.Financeiro.Margem.Faixas.index', compact('faixas'));
    }


    public function faixas_edit($id)
    {
        $faixa = FaixaPreco::findOrFail($id);
        $categorias = CategoriaMargem::all(); // Para selecionar a categoria de margem
        return view('Modulos.Financeiro.Margem.Faixas.editar', compact('faixa', 'categorias'));
    }

    public function faixas_update(Request $request, $id)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias_margem,id',
            'min' => 'required|numeric',
            'max' => 'required|numeric',
            'avista' => 'required|numeric',
            'parcelado' => 'required|numeric',
        ]);

        $faixa = FaixaPreco::findOrFail($id);
        $faixa->update($request->all());

        return redirect()->route('margem.faixas.index')->with('success', 'Faixa de preço atualizada com sucesso!');
    }



}