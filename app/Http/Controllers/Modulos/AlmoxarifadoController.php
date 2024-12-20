<?php

namespace App\Http\Controllers\Modulos;

use App\Http\Controllers\Controller;
use App\Models\Modulos\Patrimonio;
use App\Models\Modulos\Patrimonio\GrupoPatrimonio;
use App\Models\Modulos\Patrimonio\GrupoPatrimonioPatrimonio;
use App\Models\Modulos\Patrimonio\RetiradaPatrimonio;
use App\Models\Modulos\Patrimonio\SetorPat;
use App\Models\Modulos\Patrimonio\FuncaoPat;
use App\Models\Modulos\Patrimonio\TamanhoPat;
use App\Models\User;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade\Pdf;

class AlmoxarifadoController extends Controller
{
    // Setor
     // Exibir todos os setores
    public function index_setor()
    {
        $setores = SetorPat::all(); // Obtém todos os setores
        return view('Modulos.Almoxarifado.Setor.index', compact('setores')); // Retorna a view com a lista
    }

    // Mostrar o formulário para criar um novo setor
    public function create_setor()
    {
        return view('Modulos.Almoxarifado.Setor.create'); // Retorna a view de criação
    }

    // Armazenar um novo setor
    public function store_setor(Request $request)
    {
        $request->validate([
            'nome' => 'required|unique:setor_pats|max:100', // Validação para o nome único
        ]);
        SetorPat::create([
            'nome' => $request->nome, // Armazena o nome do setor
        ]);
        return redirect()->route('setores.index')->with('success', 'Setor criado com sucesso!');
    }

    // Mostrar o formulário para editar um setor
    public function edit_setor(SetorPat $setor)
    {
        return view('Modulos.Almoxarifado.Setor.edit', compact('setor')); // Retorna a view de edição com os dados do setor
    }

    // Atualizar um setor existente
    public function update_setor(Request $request, SetorPat $setor)
    {
        $request->validate([
            'nome' => 'required|max:100|unique:setor_pats,nome,' . $setor->id, // Validação com exceção do próprio setor
        ]);
        $setor->update([
            'nome' => $request->nome, // Atualiza o nome do setor
        ]);
        return redirect()->route('setores.index')->with('success', 'Setor atualizado com sucesso!');
    }

    // Deletar um setor
    public function destroy_setor(SetorPat $setor)
    {
        $setor->delete(); // Deleta o setor
        return redirect()->route('setores.index')->with('success', 'Setor excluído com sucesso!');
    }
    //End Setor
    /*------------//----------------//------------------------------------------//------------------------------------------------//--------------------------------------*/
    //Função
    public function index_funcao()
    {
        $funcaoPats = FuncaoPat::all();
        return view('Modulos.Almoxarifado.Funcao.index', compact('funcaoPats'));
    }

    public function create_funcao()
    {
        return view('Modulos.Almoxarifado.Funcao.create');
    }

    public function store_funcao(Request $request)
    {
        $request->validate([
            'nome' => 'required|unique:funcao_pats|max:100',
        ]);

        FuncaoPat::create($request->all());

        return redirect()->route('funcao.index')->with('success', 'Função criada com sucesso.');
    }

    public function edit_funcao($id)
    {
        $funcaoPat = FuncaoPat::findOrFail($id);
        return view('Modulos.Almoxarifado.Funcao.edit', compact('funcaoPat'));
    }

    public function update_funcao(Request $request, $id)
    {
        // $funcao deve conter o identificador passado na URL
        $funcaoModel = FuncaoPat::findOrFail($id);

        // Atualize os dados conforme necessário
        $funcaoModel->update($request->all());

        return redirect()->route('funcao.index')->with('success', 'Função atualizada com sucesso.');
    }

    public function destroy_funcao($id)
    {
        $funcaoPat = FuncaoPat::findOrFail($id);
        $funcaoPat->delete();

        return redirect()->route('funcao.index')->with('success', 'Função excluída com sucesso.');
    }
    //end função
    /*------------//----------------//------------------------------------------//------------------------------------------------//--------------------------------------*/

    public function index_tamanho()
    {
        $tamanhoPats = TamanhoPat::all();
        return view('Modulos.Almoxarifado.Tamanho.index', compact('tamanhoPats'));
    }

    public function create_tamanho()
    {
        return view('Modulos.Almoxarifado.Tamanho.create');
    }

    public function store_tamanho(Request $request)
    {
        $request->validate([
            'tamanho' => 'required|max:50',
        ]);

        TamanhoPat::create($request->all());

        return redirect()->route('tamanho.index')->with('success', 'Tamanho cadastrado com sucesso.');
    }

    public function edit_tamanho($id)
    {
        $tamanhoPat = TamanhoPat::findOrFail($id);
        return view('Modulos.Almoxarifado.Tamanho.edit', compact('tamanhoPat'));
    }

    public function update_tamanho(Request $request, $id)
    {   
        // $funcao deve conter o identificador passado na URL
        $tamanhoPat = TamanhoPat::findOrFail($id);

        // Atualize os dados conforme necessário
        $tamanhoPat->update($request->all());

        return redirect()->route('tamanho.index')->with('success', 'Tamanho atualizado com sucesso.');
    }

    public function destroy_tamanho($id)
    {
        $tamanhoPat = TamanhoPat::findOrFail($id);

        $tamanhoPat->delete();

        return redirect()->route('tamanho.index')->with('success', 'Tamanho excluído com sucesso.');
    }

    /*------------//----------------//------------------------------------------//------------------------------------------------//--------------------------------------*/

    // Exibir todos os itens do almoxarifado
    public function index()
    {
        $patrimonios = Patrimonio::with(['setorPat', 'funcaoPat', 'tamanhoPat'])->get();
        return view('Modulos.Almoxarifado.index', compact('patrimonios'));
    }

    public function create()
    {
        $setores = SetorPat::all();
        $funcoes = FuncaoPat::all();
        $tamanhos = TamanhoPat::all();
        return view('Modulos.Almoxarifado.create', compact('setores', 'funcoes', 'tamanhos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome_completo' => 'required|max:255',
            'series' => 'required|integer|min:1',
            'setor_pat_id' => 'nullable|exists:setor_pats,id',
            'funcao_pat_id' => 'nullable|exists:funcao_pats,id',
            'tamanho_pat_id' => 'nullable|exists:tamanho_pats,id',
            'tipo_pat' => 'required|in:1,2',
            'nova_funcao' => 'nullable|string|max:100',
            'novo_tamanho' => 'nullable|string|max:50',
        ]);

        // Verificar se o usuário digitou um novo valor para a função
        if ($request->nova_funcao) {
            $funcao = FuncaoPat::firstOrCreate(['nome' => $request->nova_funcao]);
            $funcaoId = $funcao->id;
        } else {
            $funcaoId = $request->funcao_pat_id;
        }

        // Verificar se o usuário digitou um novo valor para o tamanho
        if ($request->novo_tamanho) {
            $tamanho = TamanhoPat::firstOrCreate(['tamanho' => $request->novo_tamanho]);
            $tamanhoId = $tamanho->id;
        } else {
            $tamanhoId = $request->tamanho_pat_id;
        }

        // Garantir que o setor e a função tenham 2 dígitos
        $setorId = str_pad($request->setor_pat_id, 2, '0', STR_PAD_LEFT);
        $funcaoId = str_pad($funcaoId, 2, '0', STR_PAD_LEFT);

        $tamanho = TamanhoPat::findOrFail($tamanhoId);
        $tamanhoNome = $tamanho->tamanho;
        preg_match_all('/\d+/', $tamanhoNome, $matches);
        $tamanhoCodigo = isset($matches[0]) ? str_pad(implode('', array_slice($matches[0], 0, 3)), 3, '0', STR_PAD_LEFT) : '000';        

        // Gerar o nome_abv com 4 dígitos a partir do id
        $nomeAbv = str_pad(Patrimonio::max('id') + 1, 4, '0', STR_PAD_LEFT);

        // Gerar o código base para o patrimônio
        $codigoBase = $nomeAbv . '-' . $setorId . '-'. $request->tipo_pat . '-' . $funcaoId . '-' . $tamanhoCodigo;

        // Criar o array para as séries
        $seriesArray = [];

        // Gerar os códigos das séries e estados
        for ($i = 1; $i <= $request->series; $i++) {
            $codigo = $codigoBase . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
            $seriesArray[] = ['codigo' => $codigo, 'estado' => 'disponivel'];
        }

        // Criar o patrimônio
        Patrimonio::create([
            'codigo' => $codigoBase,
            'nome_abv' => $nomeAbv,
            'nome_completo' => $request->nome_completo,
            'series' => json_encode($seriesArray),
            'setor_pat_id' => $request->setor_pat_id,
            'funcao_pat_id' => $funcaoId,
            'tamanho_pat_id' => $tamanhoId,
            'tipo_pat' => $request->tipo_pat,
        ]);

        return redirect()->route('almoxarifado.index')->with('success', 'Patrimônio criado com sucesso.');
    }


    public function edit($id)
    {
        $patrimonio = Patrimonio::findOrFail($id);
        $setores = SetorPat::all();
        $funcoes = FuncaoPat::all();
        $tamanhos = TamanhoPat::all();
        return view('Modulos.Almoxarifado.edit', compact('patrimonio', 'setores', 'funcoes', 'tamanhos'));
    }

    public function update(Request $request, $id)
    {
        // Encontra o patrimônio pelo id fornecido
        $patrimonio = Patrimonio::findOrFail($id);
    
        // Validação dos dados
        $request->validate([
            'nome_completo' => 'required|max:255',
            'series' => 'required|integer|min:1',
            'setor_pat_id' => 'nullable|exists:setor_pats,id',
            'funcao_pat_id' => 'nullable|exists:funcao_pats,id',
            'tamanho_pat_id' => 'nullable|exists:tamanho_pats,id',
        ]);
    
        // Garantir que o setor e a função tenham 2 dígitos
        $setorId = str_pad($request->setor_pat_id, 2, '0', STR_PAD_LEFT);
        $funcaoId = str_pad($request->funcao_pat_id, 2, '0', STR_PAD_LEFT);
    
        // Extrair os 3 primeiros números do nome do tamanho, completando com zero se necessário
        $tamanho = TamanhoPat::findOrFail($request->tamanho_pat_id);
        $tamanhoNome = $tamanho->tamanho;
        preg_match_all('/\d+/', $tamanhoNome, $matches);
        $tamanhoCodigo = isset($matches[0]) ? str_pad(implode('', array_slice($matches[0], 0, 3)), 3, '0', STR_PAD_LEFT) : '000';
    
        // O nome_abv já existe no banco de dados, então não alteramos o valor para manter o id correto
        // Gerar o código base para o patrimônio (com 2 dígitos para setor, função e o código de tamanho)
        $codigoBase = $patrimonio->nome_abv . '-' . $setorId . '-' . $funcaoId . '-' . $tamanhoCodigo;
    
        // Criar o array para as séries
        $seriesArray = [];
    
        // Gerar os códigos das séries e estados
        for ($i = 1; $i <= $request->series; $i++) {
            // Gerar o código da série para a série atual
            $codigo = $codigoBase . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);  // Exemplo: nome_abv-1-2-3-01
    
            // Adicionar o código e o estado da série ao array (estado pode ser 'disponível' ou 'indisponível')
            $seriesArray[] = [
                'codigo' => $codigo,
                'estado' => 'disponivel',  // Ou 'indisponível', dependendo da lógica do seu sistema
            ];
        }
    
        // Atualizar o patrimônio
        $patrimonio->update([
            'codigo' => $codigoBase,  // Código base do patrimônio
            'nome_abv' => $patrimonio->nome_abv,  // Manter o nome_abv já existente
            'nome_completo' => $request->nome_completo,
            'series' => json_encode($seriesArray),  // Atualizar as séries como JSON
            'setor_pat_id' => $request->setor_pat_id,
            'funcao_pat_id' => $request->funcao_pat_id,
            'tamanho_pat_id' => $request->tamanho_pat_id,
        ]);
    
        // Redireciona com mensagem de sucesso
        return redirect()->route('almoxarifado.index')->with('success', 'Patrimônio atualizado com sucesso.');
    }
    


    public function destroy($id)
    {
        $patrimonio = Patrimonio::findOrFail($id);

        $patrimonio->delete();
        return redirect()->route('almoxarifado.index')->with('success', 'Patrimônio excluído com sucesso.');
    }

    public function generateBarcode($id)
    {
        $patrimonio = Patrimonio::find($id);
        $series = json_decode($patrimonio->series);

        return view('Modulos.Almoxarifado.barcode', [
            'series' => $series,
            'nome_completo' => $patrimonio->nome_completo // Passando o nome completo
        ]);
    }

    /*-------------------------------------Grupo PATRIMONIO-------------------------------------------------------------------------------*/
    public function index_grupo()
    {
        // Buscar todos os grupos de patrimônio
        $grupos = GrupoPatrimonio::all();

        // Retornar a view com os dados dos grupos
        return view('Modulos.Almoxarifado.Grupo.index', compact('grupos'));
    }
    
    public function create_grupo()
    {
        $setores = SetorPat::all(); // Obtém todos os setores
        return view('Modulos.Almoxarifado.Grupo.create', compact('setores'));
    }

    
    public function store_grupo(Request $request)
    {
        $validated = $request->validate([
            'id_setor' => 'required|exists:setor_pats,id',
            'nome' => 'required|string|max:255',
        ]);

        $grupoPatrimonio = GrupoPatrimonio::create([
            'id_setor' => $validated['id_setor'],
            'nome' => $validated['nome'],
            'estado' => 'disponivel', // padrão
        ]);

        return redirect()->route('grupo_patrimonios.index')->with('success', 'Grupo criado com sucesso.');
    }

    // Método para exibir o formulário de edição
    public function edit_grupo($id)
    {
        // Buscar o grupo pelo ID
        $grupo = GrupoPatrimonio::findOrFail($id);
        // Buscar os setores para popular o campo de setor no formulário
        $setores = SetorPat::all();
        return view('Modulos.Almoxarifado.Grupo.edit', compact('grupo', 'setores'));
    }

    // Método para atualizar o grupo
    public function update_grupo(Request $request, $id)
    {
        // Validar os dados recebidos
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'id_setor' => 'required|exists:setor_pats,id',
            'estado' => 'nullable|string|max:255',
        ]);

        // Buscar o grupo e atualizar os dados
        $grupo = GrupoPatrimonio::findOrFail($id);
        $grupo->update($validated);

        // Redirecionar com mensagem de sucesso
        return redirect()->route('grupo_patrimonios.index')->with('success', 'Grupo de Patrimônio atualizado com sucesso.');
    }

    // Método para excluir o grupo
    public function destroy_grupo($id)
    {
        // Buscar o grupo e excluí-lo
        $grupo = GrupoPatrimonio::findOrFail($id);
        $grupo->delete();

        // Redirecionar com mensagem de sucesso
        return redirect()->route('grupo_patrimonios.index')->with('success', 'Grupo de Patrimônio excluído com sucesso.');
    }

    public function adicionarPatrimonioView($grupoPatrimonioId)
    {
        // Busca todos os patrimônios
        $patrimonio = Patrimonio::all();

        // Converte os dados em JSON
        //$patrimonio = $patrimonioaux->toJson();
        // Retorna a view com o JSON do patrimônio
        return view('Modulos.Almoxarifado.Grupo.adicionar', compact('grupoPatrimonioId', 'patrimonio'));
    }


    public function adicionarPatrimonio(Request $request, $grupoPatrimonioId)
    {
        // Validar os dados recebidos
        $request->validate([
            'patrimonios' => 'required|array|min:1',  // Garantir que pelo menos um patrimônio foi selecionado
            'patrimonios.*' => 'exists:patrimonios,id', // Garantir que todos os IDs de patrimônio existam
            'seriesSelecionados' => 'required|string',
        ]);
    
        // Converter os códigos de série recebidos para um array
        $codigosSerieArray = explode(',', $request->input('seriesSelecionados'));
        // Buscar o grupo patrimonial
        $grupoPatrimonio = GrupoPatrimonio::findOrFail($grupoPatrimonioId);
    
        // Loop pelos patrimonios selecionados
        foreach ($request->patrimonios as $patrimonioId) {
            $patrimonio = Patrimonio::find($patrimonioId);
            if ($patrimonio) {
                if (!empty($patrimonio->series)) {
                    $series = json_decode($patrimonio->series);
                    if (is_array($series)) {
                        foreach ($series as $serie) {
                            if (isset($serie->codigo) && in_array($serie->codigo, $codigosSerieArray)) {
                                // Aqui você pode realizar qualquer alteração desejada
                                // Vamos adicionar ao estado o id do grupo como 'disponivel'
                                $serie->estado = 'disponivel-G:' . $grupoPatrimonioId;
                            
                                // Adiciona o item no grupo patrimonial
                                GrupoPatrimonioPatrimonio::create([
                                    'id_grupo_patrimonio' => $grupoPatrimonioId,
                                    'id_patrimonio' => $patrimonioId,
                                    'nome' => $patrimonio->nome_completo,
                                    'serie' => json_encode($serie->codigo),
                                ]); 
                            }                                                               
                        }
                    }
                }
                // Atualizar o patrimônio com a nova série
                 // Atualizar o campo `series` com o novo JSON
                 $patrimonio->series = json_encode($series); // Re-encode o array para JSON
                 $patrimonio->save(); 
            }
        }
    
        return redirect()->route('grupo_patrimonios.index')->with('success', 'Grupo criado e patrimonios anexados com sucesso!');
    }

    public function listarFerramentas($grupoId)
    {
        // Obter o grupo de patrimônio
        $grupo = GrupoPatrimonio::findOrFail($grupoId);

        // Obter os itens (ferramentas) associados a este grupo
        $itens = GrupoPatrimonioPatrimonio::where('id_grupo_patrimonio', $grupoId)->get();

        return view('Modulos.Almoxarifado.Grupo.ferramentas', compact('grupo', 'itens'));
    }

    public function deleteItem($grupoId, $itemId)
    {
        // Encontrar o item do grupo
        $item = GrupoPatrimonioPatrimonio::findOrFail($itemId);
        
        $patrimonio = Patrimonio::find($item->id_patrimonio);
        if ($patrimonio) {
            if (!empty($patrimonio->series)) {
                $series = json_decode($patrimonio->series);
                if (is_array($series)) {
                    foreach ($series as $serie) {
                        if (isset($serie->codigo)) {
                            // Aqui você pode realizar qualquer alteração desejada
                            // Vamos adicionar ao estado o id do grupo como 'disponivel'
                            $serie->estado = 'disponivel';
                        }                                                                                       
                    }
                }
                // Atualizar o campo `series` com o novo JSON
                $patrimonio->series = json_encode($series); // Re-encode o array para JSON
                $patrimonio->save();
            }
        }
        
        // Excluir o item
        $item->delete();
        
        // Retornar para a página de ferramentas do grupo com uma mensagem de sucesso
        return redirect()->route('grupo_patrimonios.index', $grupoId)->with('success', 'Ferramenta excluída com sucesso e o estado da série foi alterado para disponível.');
    }

    /*---------------------------RETIRADA DE <PATRIMONIO-------------------------------------------------------------------------------------------------------------------PATRIMONIO-------------------------------------------------------------------------------------------------------------------*/
    public function index_retirada()
    {
        // Buscar todas as retiradas de patrimônio, ordenadas pela data mais recente
        $retiradas = RetiradaPatrimonio::with(['responsavel', 'tecnicoResponsavel'])->orderBy('created_at', 'asc')->paginate(10);

        return view('Modulos.Almoxarifado.Retirada.index', compact('retiradas'));
    }

    
    public function create_retirada()
    {
        $users = User::all();
        $patrimonio = Patrimonio::all();
        $grupo = GrupoPatrimonio::all();

        return view('Modulos.Almoxarifado.Retirada.create', compact('users', 'patrimonio', 'grupo'));
    }

    public function store_retirada(Request $request)
    {       
        // Validar os dados
        $request->validate([
            'series_selecionados' => 'nullable|string', 
            'id_user_resp' => 'required|exists:users,id',
            'id_user_tec' => 'required|exists:users,id',
            'patrimonios' => 'nullable|array',  
            'grupos' => 'nullable|array',  // Altere para nullable se grupos não forem obrigatórios
            'anotacoes' => 'nullable|string',
        ]);

        // Preparar os dados antes de salvar
        $patrimonios = json_encode($request->patrimonios); // Series selecionadas em formato JSON
        $grupos = json_encode($request->grupos);  // Grupos em formato JSON
    

        // Criar a retirada
        $retirada = RetiradaPatrimonio::create([
            'id_user_resp' => $request->id_user_resp,
            'id_user_tec' => $request->id_user_tec,
            'patrimonios' => $patrimonios,  // Salva as séries como JSON
            'grupos' => $grupos,  // Salva os grupos como JSON
            'anotacoes' => $request->anotacoes,
            'estado' => 'Pendente',
        ]);

        // Se houver grupos, alterar o estado dos grupos de 'disponível' para 'indisponível'
        if ($request->has('grupos')) {
            foreach ($request->grupos as $grupoId) {
                // Buscar o grupo
                $grupo = GrupoPatrimonio::find($grupoId);
        
                if ($grupo) {
                    // Atualiza o estado do grupo para 'indisponível' com a referência da retirada
                    $grupo->update([
                        'estado' => 'indisponível->R:' . $retirada->id, // Atualiza o estado do grupo
                    ]);
                }
        
                // Consultar os itens de patrimônio relacionados ao grupo
                $grupoPatrimonioItems = GrupoPatrimonioPatrimonio::where('id_grupo_patrimonio', $grupoId)->get();

                // Para cada item de patrimônio no grupo
                foreach ($grupoPatrimonioItems as $item) {
                    // Pegue o ID do patrimônio e busque o patrimônio na tabela 'patrimonio'
                    $patrimonio = Patrimonio::find($item->id_patrimonio); // Busca o patrimônio pelo ID

                    if ($patrimonio && isset($patrimonio->series)) {
                        // Verifique se a série está preenchida
                        if (!empty($patrimonio->series)) {
                            // Decodifique o campo `series` como um array associativo
                            $series = json_decode($patrimonio->series, true); // Passando `true` para um array associativo
                            
                            if (is_array($series)) {
                                // Encontrar a série específica do item
                                $serieCodigo = trim($item->serie, '"');
                                foreach ($series as $key => $serie) {
                                    // Verifique se a série corresponde ao item de patrimônio
                                    if (isset($serie['codigo']) && $serie['codigo'] == $serieCodigo) { // Supondo que 'serie_codigo' seja o campo que identifica a série corretamente
                                        // Atualizar o estado da série para 'indisponível' com a referência do grupo e retirada

                                        
                                        $series[$key]['estado'] = 'indisponivel->G:' . $grupo->id . '->R:' . $retirada->id;
                                    }
                                }
                            }

                            // Atualize o campo `series` com o novo estado
                            $patrimonio->series = json_encode($series); // Re-encode o array para JSON
                            $patrimonio->save(); // Salve o patrimônio com o novo estado
                        }
                    }
                }

            }
        }

        // Se houver patrimônios selecionados
        if ($request->has('patrimonios')) {
            foreach ($request->patrimonios as $serieCodigoCompleto) {
                // Remover as aspas extras, caso estejam presentes
                $serieCodigoCompleto = trim($serieCodigoCompleto, '"');
        
                // Remover os últimos 3 dígitos para obter o código base
                $codigoBase = substr($serieCodigoCompleto, 0, -3);
        
                // Buscar o patrimônio com o código base
                $patrimonio = Patrimonio::where('codigo', $codigoBase)->first();
        
                if ($patrimonio && isset($patrimonio->series)) {
                    // Decodificar o campo `series` como um array associativo
                    $series = json_decode($patrimonio->series, true); // `true` para array associativo
        
                    if (is_array($series)) {
                        // Procurar o código de série específico no JSON
                        foreach ($series as $key => $serie) {
                            if (isset($serie['codigo']) && $serie['codigo'] === $serieCodigoCompleto) {
                                // Atualizar o estado da série correspondente
                                $series[$key]['estado'] = 'indisponivel->R:' . $retirada->id;
                                break; // Encontrado o código, pode sair do loop
                            }
                        }
                    }
        
                    // Atualizar o campo `series` com o novo JSON
                    $patrimonio->series = json_encode($series);
                    $patrimonio->save();
                }
            }
        }
        
        


        // Redirecionar para a página de visualização com mensagem de sucesso
        return redirect()->route('retiradas.index', $retirada->id)->with('success', 'Retirada de patrimônio gerada com sucesso!');
    }

    public function generatePdf($id)
    {
        // Recuperar os dados da retirada de patrimônio com base no ID
        $retirada = RetiradaPatrimonio::findOrFail($id);

        $patrimonioAll = Patrimonio::all();
        $grupoAll = GrupoPatrimonio::all();
        $itemsgrupoAll = GrupoPatrimonioPatrimonio::all();

        // Gerar o PDF a partir da view 'retirada.pdf' e passar os dados da retirada
        $pdf = PDF::loadView('Modulos.Almoxarifado.Retirada.pdf', compact('retirada', 'patrimonioAll', 'grupoAll', 'itemsgrupoAll'));

        // Exibir o PDF no navegador
        return $pdf->stream('retirada_' . $retirada->id . '.pdf');
    }

    // Exibe o formulário de retorno
    public function showRetornoForm()
    {
        return view('Modulos.Almoxarifado.Retirada.retorno');
    }

    // Processa a busca da retirada
    public function buscar(Request $request)
    {
        // Recupera o termo de busca enviado pelo formulário
        $termoBusca = $request->input('id_retirada');        
        // Buscar o ID de retirada com base no termo de busca (ID ou nome)
        $retirada = RetiradaPatrimonio::find($termoBusca);

        $patrimonioAll = Patrimonio::all();
        $grupoAll = GrupoPatrimonio::all();
        $itemsgrupoAll = GrupoPatrimonioPatrimonio::all();

        // Retorna a visualização com os resultados da busca
        return view('Modulos.Almoxarifado.Retirada.retorno', compact('retirada', 'patrimonioAll', 'grupoAll', 'itemsgrupoAll'));
    }


    // Confirma a volta da retirada e atualiza o estado
    public function confirmarVolta(Request $request, $id)
    {   
        $lostGrupos = $request->has('lost_grupos') ? $request->input('lost_grupos') : [];

        // Verifica se existe algum valor para lost_patrimonios na requisição
        $lostPatrimonios = $request->has('lost_patrimonios') ? $request->input('lost_patrimonios') : [];

        // Recupera a retirada pelo ID
        $retirada = RetiradaPatrimonio::findOrFail($id);
        
        // Verifica se a retirada está em um estado que permite a devolução
        if ($retirada->estado !== 'Pendente') {
            return redirect()->route('retiradas.index')->with('error', 'Esta retirada não pode ser devolvida.');
        }
    
        

        // Decodifica o campo 'grupos' (JSON para array)
        $grupos = json_decode($retirada->grupos, true);
        // Se houver grupos, alterar o estado dos grupos de 'disponível' para 'indisponível'
        if (is_array($grupos) && !empty($grupos)) {
            foreach ($grupos as $grupoId) {
                // Buscar o grupo
                $grupo = GrupoPatrimonio::find($grupoId);
        
                if ($grupo) {
                    // Atualiza o estado do grupo para 'indisponível' com a referência da retirada
                    $grupo->update([
                        'estado' => 'disponivel' // Atualiza o estado do grupo
                    ]);
                }
        
                // Consultar os itens de patrimônio relacionados ao grupo
                $grupoPatrimonioItems = GrupoPatrimonioPatrimonio::where('id_grupo_patrimonio', $grupoId)->get();

                // Para cada item de patrimônio no grupo
                foreach ($grupoPatrimonioItems as $item) {
                    // Pegue o ID do patrimônio e busque o patrimônio na tabela 'patrimonio'
                    $patrimonio = Patrimonio::find($item->id_patrimonio); // Busca o patrimônio pelo ID

                    if ($patrimonio && isset($patrimonio->series)) {
                        // Verifique se a série está preenchida
                        if (!empty($patrimonio->series)) {
                            // Decodifique o campo `series` como um array associativo
                            $series = json_decode($patrimonio->series, true); // Passando `true` para um array associativo
                            
                            if (is_array($series)) {
                                // Encontrar a série específica do item
                                $serieCodigo = trim($item->serie, '"');
                                foreach ($series as $key => $serie) {
                                    // Verifique se a série corresponde ao item de patrimônio
                                    if (isset($serie['codigo']) && $serie['codigo'] == $serieCodigo) {
                                       
                                        
                                        // Verifica se o serieCodigo está em lost_grupos
                                        if (!empty($lostGrupos)) {
                                            foreach ($lostGrupos as $codigo => $descricao) {
                                                $codigo = trim($codigo, '"');
                                                if ($codigo === $serieCodigo) {
                                                    // Se encontrado, altera o estado para "indisponível" com a referência do grupo e o marcador 'L' para Lost
                                                    $series[$key]['estado'] = 'indisponivel->G:' . $grupo->id . '->L:' . $descricao;
                                                    break;
                                                }
                                            }                                        
                                        } else {
                                            // Se não encontrado, altera o estado para "disponível" com a referência do grupo
                                            $series[$key]['estado'] = 'disponivel->G:' . $grupo->id;
                                        }
                                    }
                                }
                            }

                            // Atualize o campo `series` com o novo estado
                            $patrimonio->series = json_encode($series); // Re-encode o array para JSON
                            $patrimonio->save(); // Salve o patrimônio com o novo estado
                        }
                    }
                }

            }
        }

        $patrimonios = json_decode($retirada->patrimonios, true);
        
        if (is_array($patrimonios) && !empty($patrimonios)) {
            foreach ($patrimonios as $serieCodigoCompleto) {
                // Remover as aspas extras, caso estejam presentes
                $serieCodigoCompleto = trim($serieCodigoCompleto, '"');
        
                // Remover os últimos 3 dígitos para obter o código base
                $codigoBase = substr($serieCodigoCompleto, 0, -3);
        
                // Buscar o patrimônio com o código base
                $patrimonio = Patrimonio::where('codigo', $codigoBase)->first();
        
                if ($patrimonio && isset($patrimonio->series)) {
                    // Decodificar o campo `series` como um array associativo
                    $series = json_decode($patrimonio->series, true); // `true` para array associativo
        
                    if (is_array($series)) {
                        // Procurar o código de série específico no JSON
                        foreach ($series as $key => $serie) {
                            if (isset($serie['codigo']) && $serie['codigo'] === $serieCodigoCompleto) {
                                if (!empty($lostPatrimonios)) {
                                    foreach ($lostPatrimonios as $codigo => $descricao) {
                                        $codigo = trim($codigo, '"');
                                        if ($codigo === $serieCodigoCompleto) {
                                            // Se encontrado, altera o estado para "indisponível" com a referência do grupo e o marcador 'L' para Lost
                                            $series[$key]['estado'] = 'indisponivel->L:' . $descricao;
                                            break;
                                        }
                                    }                                        
                                } else {
                                // Atualizar o estado da série correspondente
                                $series[$key]['estado'] = 'disponivel';
                                break; // Encontrado o código, pode sair do loop
                                }
                            }
                        }
                    }
        
                    // Atualizar o campo `series` com o novo JSON
                    $patrimonio->series = json_encode($series);
                    $patrimonio->save();
                }
            }
        }
        
        // Atualiza o status da retirada para "devolvido"
        $retirada->estado = 'Finalizado';
    
        // Salva as alterações
        $retirada->save();
        
        // Redireciona de volta com uma mensagem de sucesso
        return redirect()->route('retiradas.index')->with('success', 'A devolução foi confirmada com sucesso.');
    }
    
    public function listarPatrimonios()
    {
        $patrimonios= Patrimonio::with(['setorPat', 'funcaoPat', 'tamanhoPat'])->get();
    
        return view('Modulos.Almoxarifado.list', compact('patrimonios'));
    }


}
