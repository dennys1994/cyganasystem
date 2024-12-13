<?php

namespace App\Http\Controllers\Modulos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Modulos\Bandeira;
use App\Models\Modulos\Taxa;

class BandeiraController extends Controller
{
    public function index()
    {
        $bandeiras = Bandeira::with('taxas')->get();
        return view('Modulos.Financeiro.CalculadoraMaquininha.index', compact('bandeiras'));
    }

    public function create()
    {
        return view('Modulos.Financeiro.CalculadoraMaquininha.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|unique:bandeiras'
        ]);

        Bandeira::create($request->all());
        return redirect()->route('bandeiras.index');
    }

    public function edit($id)
    {
        $bandeira = Bandeira::findOrFail($id);
        return view('Modulos.Financeiro.CalculadoraMaquininha.edit', compact('bandeira'));
    }

    public function update(Request $request, $id)
    {
        $bandeira = Bandeira::findOrFail($id);
        $bandeira->update($request->all());
        return redirect()->route('bandeiras.index');
    }

    public function destroy($id)
    {
        Bandeira::destroy($id);
        return redirect()->route('bandeiras.index');
    }

    public function store_taxa(Request $request)
    {
        $request->validate([
            'bandeira_id' => 'required',
            'parcelas' => 'required|integer',
            'percentual' => 'required|numeric'
        ]);

        Taxa::create($request->all());
        return redirect()->route('bandeiras.index');
    }

    public function destroy_taxa($id)
    {
        Taxa::destroy($id);
        return back();
    }

    public function edit_taxa($id)
    {
        // Recuperar a taxa com o ID fornecido
        $taxa = Taxa::findOrFail($id);
        
        // Retornar a view de edição com a taxa encontrada
        return view('taxas.edit', compact('taxa'));
    }

    // Método para atualizar a taxa no banco de dados
    public function update_taxa(Request $request, $id)
    {
        // Validar os dados recebidos no formulário
        $request->validate([
            'parcelas' => 'required|integer|min:1',
            'percentual' => 'required|numeric|min:0',
        ]);

        // Recuperar a taxa com o ID fornecido
        $taxa = Taxa::findOrFail($id);

        // Atualizar os campos da taxa
        $taxa->parcelas = $request->input('parcelas');
        $taxa->percentual = $request->input('percentual');

        // Salvar as alterações no banco de dados
        $taxa->save();

        // Redirecionar de volta para a página de listagem com uma mensagem de sucesso
        return redirect()->route('bandeiras.show', $taxa->bandeira_id)
                         ->with('success', 'Taxa atualizada com sucesso!');
    }

    // Método para exibir a calculadora
    public function showCalculadora()
    {
        // Recuperar todas as bandeiras cadastradas
        $bandeiras = Bandeira::all();

        return view('Modulos.Financeiro.CalculadoraMaquininha.calc', compact('bandeiras'));
    }

    // Método para calcular as taxas
    public function calcularTaxas(Request $request)
    {
        $bandeiras = Bandeira::all();
        // Validar os dados do formulário
        $request->validate([
            'bandeira_id' => 'required|exists:bandeiras,id',
            'valor' => 'required|numeric|min:0',
        ]);

        // Recuperar a bandeira selecionada
        $bandeira = Bandeira::findOrFail($request->bandeira_id);

        // Recuperar as taxas da bandeira
        $taxas = $bandeira->taxas;

        // Calcular o valor das parcelas de acordo com as taxas
        $resultados = [];
        foreach ($taxas as $taxa) {
            $parcelas = $taxa->parcelas;
            $percentual = $taxa->percentual;

            
            $valorParcelado = $request->valor / (1 - ($percentual/100));

            $valorParcela = $valorParcelado / $parcelas;

            // Armazenar o resultado do cálculo
            $resultados[] = [
                'parcelas' => $parcelas,
                'valorTotal' => number_format($valorParcelado, 2, ',', '.'),
                'valorParcela' => number_format($valorParcela, 2, ',', '.'),
            ];
        }

        // Retornar para a página com os resultados
        return view('Modulos.Financeiro.CalculadoraMaquininha.calc', compact('bandeiras', 'bandeira', 'resultados'));
    }
}
