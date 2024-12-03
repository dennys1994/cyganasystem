<?php

namespace App\Http\Controllers\Modulos;

use App\Models\Modulos\RelatorioUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

use Carbon\Carbon;

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

    public function listarOrdensServico(Request $request)
    {
        // Validar se há um usuário com auth_milvus configurado
        $authMilvus = RelatorioUser::whereNotNull('auth_milvus')->first();

        if (!$authMilvus) {
            return back()->with('error', 'Nenhuma credencial Milvus configurada.');
        }

        // Validar cliente_id
        $clienteId = $request->input('cliente_id');
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

        // Verificar se os dados já estão no cache
        if (Cache::has($cacheKey)) {
            // Se os dados já estiverem no cache, retorne-os diretamente
            $ordensServico = Cache::get($cacheKey);
            return view('Modulos.RelatorioFechamento.Relatorio.os', [
                'ordensServico' => $ordensServico,
            ]);
        }

        // Gerar chave única para o lock para garantir que apenas uma requisição aconteça
        $lockKey = "lock_ordens_servico_{$clienteId}_{$dataInicio}_{$dataFim}";

        // Verificar se já existe um lock ativo
        if (Cache::has($lockKey)) {
            // Se a requisição já está sendo processada, podemos retornar uma resposta de erro ou esperar
            return back()->with('info', 'Já existe uma requisição em andamento para este cliente e intervalo de datas.');
        }

        // Criar o lock para essa requisição
        Cache::put($lockKey, true, 5); // O lock dura 5 minutos (ajuste conforme necessário)

        try {
            // Fazer a requisição para a API
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
                return back()->with('error', 'Erro ao obter ordens de serviço da API.');
            }

            $ordensServico = $response->json();

            // Armazenar o resultado no cache por 10 minutos
            Cache::put($cacheKey, $ordensServico['lista'] ?? [], 600);

            // Retornar para a view com as ordens
            return view('Modulos.RelatorioFechamento.Relatorio.os', [
                'ordensServico' => $ordensServico['lista'] ?? [],
            ]);
        } catch (\Exception $e) {
            // Retornar uma mensagem de erro mais detalhada
            return back()->with('error', 'Erro ao processar a requisição: ' . $e->getMessage());
        } finally {
            // Remover o lock após o processamento
            Cache::forget($lockKey);
        }
    }

    public function gerarRelatorioPdf(Request $request)
    {
        $ordensServico = json_decode($request->input('ordensServico'), true);

        if (!$ordensServico) {
            return redirect()->back()->with('error', 'Nenhuma ordem de serviço encontrada para exportar.');
        }

        // Gere o PDF com as ordens de serviço (exemplo usando Dompdf)
        $pdf = PDF::loadView('Modulos.RelatorioFechamento.Relatorio.print', compact('ordensServico'))->setPaper('a4', 'portrait');
     
        return $pdf->stream('relatorio_ordens.pdf');
        
    }


}
