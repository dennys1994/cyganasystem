<?php

namespace App\Http\Controllers\Modulos;

use App\Models\Modulos\RelatorioUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade\Pdf;

class RelatorioFechamentoController extends Controller
{
    // Criar credenciais
    public function storeUser(Request $request)
    {
        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:relatorio_users,email',
            'auth_sige' => 'nullable|string',
            'app_name' => 'nullable|string',
            'auth_milvus' => 'nullable|string',
        ]);
       
        // Criar a credenciais no banco de dados
        RelatorioUser::create($validatedData);

        // Redirecionar com uma mensagem de sucesso
        return redirect()->route('relatorio.users.list')->with('success', 'Credencial criada com sucesso!');
    }


    // Listar todas as credenciais
    public function listUsers()
    {
        $relatorioUsers = RelatorioUser::all();

        return view('Modulos.RelatorioFechamento.Users.list', compact('relatorioUsers'));
    }

    // Atualizar credenciais
    public function updateUser(Request $request, $id)
    {
        $user = RelatorioUser::find($id);

        if (!$user) {
            return response()->json(['error' => 'Credencial não encontrado'], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:relatorio_users,email,' . $id,
            'auth_sige' => 'nullable|string',
            'app_name' => 'nullable|string',
            'auth_milvus' => 'nullable|string',
        ]);

        $user->update($request->all());

        return redirect()->route('relatorio.users.list')->with('success', 'Credenciais atualizado com sucesso!');
    }

    // Exibir o formulário de edição (editar credenciais)
    public function editUser($id)
    {
        $user = RelatorioUser::findOrFail($id);
        return view('Modulos.RelatorioFechamento.Users.edit', compact('user'));
    }

    // Excluir credenciais
    public function destroyUser($id)
    {
        $user = RelatorioUser::findOrFail($id);
        $user->delete();
        return redirect()->route('relatorio.users')->with('success', 'Credenciais excluídas com sucesso!');
    }

    public function getClientes(Request $request)
    {
       // Buscar o primeiro usuário com auth_milvus preenchido
        $user = RelatorioUser::whereNotNull('auth_milvus')->first();

        // Verificar se o auth_milvus está disponível
        if (!$user || !$user->auth_milvus) {
            return back()->with('error', 'Nenhum usuário com auth_milvus encontrado.');
        }

        // Token para autenticação
        $authMilvus = $user->auth_milvus;
       // A URL da API do Milvus
       $url = 'https://apiintegracao.milvus.com.br/api/cliente/busca';

       // Fazendo a requisição para a API do Milvus
       $response = Http::withHeaders([
           'Authorization' => "$authMilvus" // Passando o auth_milvus no cabeçalho
       ])->get($url);

       // Verificando se a requisição foi bem-sucedida
       if ($response->successful()) {
           // Retornando os dados para a view
           $clientes = $response->json()['lista'];
           return view('Modulos.RelatorioFechamento.Relatorio.list', compact('clientes'));
       } else {
           // Em caso de erro, retornar uma mensagem de erro
           return back()->with('error', 'Erro ao buscar clientes.');
       }
    }

    public function listarOrdensServico(Request $request, $clienteId, $cnpj)
    {
        
        // Validar se há um usuário com auth_milvus configurado
        $authMilvus = RelatorioUser::whereNotNull('auth_milvus')->first();

        if (!$authMilvus) {
            return back()->with('error', 'Nenhuma credencial Milvus configurada.');
        }

        // Validar cliente_id
        if (!$clienteId) {
            return back()->with('error', 'É necessário selecionar um cliente.');
        }

        // Obter as datas inicial e final
        $dataInicio = $request->query('data_inicial');
        $dataFim = $request->query('data_final');
        // Verificar se as datas foram passadas corretamente
        if (!$dataInicio || !$dataFim) {
            return back()->with('error', 'É necessário selecionar um intervalo de datas.');
        }

        // Verificar se as datas têm o formato correto
        try {
            $dataInicio = Carbon::createFromFormat('Y-m-d', $dataInicio)->toDateString();
            $dataFim = Carbon::createFromFormat('Y-m-d', $dataFim)->toDateString();
        } catch (\Exception $e) {
            return back()->with('error', 'Formato de data inválido. Por favor, use o formato YYYY-MM-DD.');
        }

        // Gerar chave única para o lock e cache
        $cacheKey = "ordens_servico_{$clienteId}_{$dataInicio}_{$dataFim}";

        // Inicializar os totais de tempo
        $totalTempos = [
            'N1' => 0,
            'N2' => 0,
            'N3' => 0,
            'Sem Tempo' => [],  // Lista para ordens sem tempo
            'ordens' => [], 
        ];

        // Verificar se os dados já estão no cache
        if (Cache::has($cacheKey)) {
            // Recuperar dados do cache
            $cacheData = Cache::get($cacheKey);
            return view('Modulos.RelatorioFechamento.Relatorio.os', [
                'ordensServico' => $cacheData['ordensServico'],
                'dadosSigecloud' => $cacheData['dadosSigecloud'],
                'totalTempos' => $cacheData['totalTempos'],
                'totalOrdens' => $cacheData['totalOrdens'],
            ]);
        }

        // Gerar chave única para o lock para garantir que apenas uma requisição aconteça
        $lockKey = "lock_ordens_servico_{$clienteId}_{$dataInicio}_{$dataFim}";

        if (Cache::has($lockKey)) {
            return back()->with('info', 'Já existe uma requisição em andamento para este cliente e intervalo de datas.');
        }

        // Criar o lock para essa requisição
        Cache::put($lockKey, true, 5);

        try {
            // Fazer a requisição para a API Milvus (como já está feito)
            $url = 'https://apiintegracao.milvus.com.br/api/chamado/listagem';
            $filtroBody = [
                "filtro_body" => [
                    "cliente_id" => $clienteId,
                    "data_hora_criacao_inicial" => $dataInicio,
                    "data_hora_criacao_final" => $dataFim,
                ]
            ];

            $response = Http::withHeaders([
                'Authorization' => $authMilvus->auth_milvus,
                'Content-Type' => 'application/json'
            ])->post($url, $filtroBody);

            if ($response->failed()) {
                return back()->with('error', 'Erro ao obter ordens de serviço da API Milvus.');
            }

            $ordensServico = $response->json()['lista'] ?? [];
            


            // Adicionar a chamada à API Sigecloud
            $authSige = $authMilvus->auth_sige;  // Supondo que a variável auth_sige exista
            $user = $authMilvus->email;
            $app = $authMilvus->app_name;
            $urlSigecloud = 'https://api.sigecloud.com.br/request/Pedidos/Pesquisar';

            // Montando os parâmetros manualmente, sem que os dois pontos sejam escapados
            $dataInicial = $dataInicio . 'T00:00:00Z';
            $dataFinal = $dataFim . 'T23:59:59Z';

            // A URL completa que você já montou
            $urlCompleta = $urlSigecloud . '?cpf_cnpj=' . $cnpj . '&dataInicial=' . $dataInicial . '&dataFinal=' . $dataFinal;

            // Realizando a requisição GET com a URL completa
            $responseSigecloud = Http::withHeaders([
                'Authorization-Token' => $authSige,
                'User' => $user,
                'App' => $app
            ])->get($urlCompleta);  // Usando a URL completa aqui

            // Verificando se a requisição falhou
            if ($responseSigecloud->failed()) {
                return back()->with('error', 'Erro ao obter dados da API Sigecloud.');
            }

            // Processando os dados retornados
            $dadosSigecloud = $responseSigecloud->json() ?? [];


            // Calcular tempos por nível
            foreach ($ordensServico as &$ordem) {
                if (isset($ordem['servico_realizado']) && ($ordem['status'] === 'Finalizado')) {
                  // Expressão regular ajustada para capturar horas e minutos, considerando variações no formato
                    preg_match_all('/(\d+)\s*(h|hr|hora|horas|min|minuto|minutos|m)?\s*(\d+)?\s*(min|minuto|minutos|m)?\s*(n1|n2|n3)/i', $ordem['servico_realizado'], $matches, PREG_SET_ORDER);

                    // Flag para verificar se algum tempo foi encontrado
                    $tempoEncontrado = false;

                    // Percorre todas as correspondências encontradas pela expressão regular
                    foreach ($matches as $match) {
                        // Captura as partes relevantes
                        $horas = 0; // Inicializa horas com 0
                        $minutos = 0; // Inicializa minutos com 0
                        $nivel = isset($match[5]) ? strtoupper($match[5]) : null; // Nível (N1, N2, N3)

                        // Verifica se o primeiro número é seguido por 'h', 'hr', 'hora', 'horas', que indica horas
                        if (isset($match[2]) && in_array(strtolower($match[2]), ['h', 'hr', 'hora', 'horas'])) {
                            $horas = (int)$match[1];  // Número de horas
                        }

                        // Verifica se o primeiro número é seguido por 'min', 'minuto', 'minutos', que indica minutos
                        elseif (isset($match[2]) && in_array(strtolower($match[2]), ['min', 'minuto', 'minutos', 'm'])) {
                            $minutos = (int)$match[1];  // Número de minutos
                        }

                        // Caso não tenha sido identificado como horas ou minutos no primeiro match, verifica o terceiro campo (caso tenha)
                        if (isset($match[3]) && in_array(strtolower($match[4]), ['min', 'minuto', 'minutos', 'm'])) {
                            $minutos = (int)$match[3];  // Atribui o terceiro valor aos minutos
                        }

                        // Calcula o total em minutos
                        $totalMinutos = ($horas * 60) + $minutos;

                        // Se o nível e o total de minutos forem válidos, registra a ordem
                        if ($nivel && $totalMinutos > 0) {
                            $totalTempos['ordens'][] = [
                                'numero_ordem' => $ordem['codigo'],  // Número da ordem
                                'tempo_lido'   => $totalMinutos,     // Tempo lido em minutos (não dividido por 60, pois estamos lidando com minutos diretamente)
                                'classe'       => $nivel,            // Classe associada (N1, N2, N3)
                            ];
                        }

                        // Converte para horas e adiciona ao nível correspondente
                        if ($nivel && isset($totalTempos[$nivel])) {
                            $totalTempos[$nivel] += $totalMinutos; // Adiciona em horas para o nível (não converte de novo se já estiver em minutos)
                        }

                        // Marca que encontramos algum tempo
                        if ($totalMinutos > 0) {
                            $tempoEncontrado = true;
                        }
                    }

                    // Se não encontrou tempo, adiciona à lista de ordens sem tempo
                    if (!$tempoEncontrado) {
                        $totalTempos['Sem Tempo'][] = $ordem['codigo'];
                    }
                }                
            }
            $totalOrdens = count($ordensServico);

            // Cachear os resultados em uma única estrutura
            Cache::put($cacheKey, [
                'ordensServico' => $ordensServico,
                'dadosSigecloud' => $dadosSigecloud,
                'totalOrdens' => count($ordensServico),
                'totalTempos' => $totalTempos,
            ], 600);

            return view('Modulos.RelatorioFechamento.Relatorio.os', [
                'ordensServico' => $ordensServico,
                'totalTempos' => $totalTempos,
                'totalOrdens' => $totalOrdens,
                'dadosSigecloud' => $dadosSigecloud,
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao processar a requisição: ' . $e->getMessage());
        } finally {
            Cache::forget($lockKey);
        }
    }




    public function gerarRelatorioPdf(Request $request)
    {
        $ordensServico = json_decode($request->input('ordensServico'), true);
        $dadosSigecloud = json_decode($request->input('dadosSigecloud'), true);
    
         // Calculando os totais de tempos e valores
        $totalTempos = json_decode($request->input('totalTempos'), true);
        
        if (!$ordensServico && !$dadosSigecloud) {
            return redirect()->back()->with('error', 'Nenhuma informação encontrada para exportar.');
        }
        
        
        // Gere o PDF passando os dois arrays para a view
        $pdf = PDF::loadView('Modulos.RelatorioFechamento.Relatorio.print', compact('ordensServico', 'dadosSigecloud', 'totalTempos'))
            ->setPaper('a4', 'portrait');
        
        return $pdf->stream('relatorio_ordens.pdf');
    }
    
    public function limparCache()
    {
        // Limpar todo o cache
        Cache::flush();

        // Retorne com uma mensagem de sucesso
        return redirect()->back()->with('success', 'Todo o cache foi limpo com sucesso!');
    }



}
