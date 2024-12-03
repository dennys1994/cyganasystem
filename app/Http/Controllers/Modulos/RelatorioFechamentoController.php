<?php

namespace App\Http\Controllers\Modulos;

use App\Models\Modulos\RelatorioUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RelatorioFechamentoController extends Controller
{
    private $sigecloudUrl = 'https://api.sigecloud.com.br'; // Exemplo
    private $milvusUrl = 'https://api.milvus.com.br'; // Exemplo

    public function getRelatorio(Request $request)
    {
        // Obtendo Authorization-Token do SigeCloud
        $sigecloudToken = $request->header('Authorization-Token');
        $milvusAuth = $request->header('Authorization');

        if (!$sigecloudToken || !$milvusAuth) {
            return response()->json(['error' => 'Tokens de autenticação ausentes'], 401);
        }

        // Comunicação com a API do SigeCloud
        $responseSigeCloud = Http::withHeaders([
            'Authorization-Token' => $sigecloudToken,
        ])->get("{$this->sigecloudUrl}/relatorios");

        if ($responseSigeCloud->failed()) {
            return response()->json(['error' => 'Falha ao comunicar com o SigeCloud'], 500);
        }

        // Comunicação com a API do Milvus
        $responseMilvus = Http::withHeaders([
            'Authorization' => $milvusAuth,
        ])->get("{$this->milvusUrl}/fechamento");

        if ($responseMilvus->failed()) {
            return response()->json(['error' => 'Falha ao comunicar com o Milvus'], 500);
        }

        // Combinar e retornar os dados das APIs
        return response()->json([
            'sigecloud' => $responseSigeCloud->json(),
            'milvus' => $responseMilvus->json(),
        ]);
    }

    // Criar usuário
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
       
        // Criar o usuário no banco de dados
        RelatorioUser::create($validatedData);

        // Redirecionar com uma mensagem de sucesso
        return redirect()->route('relatorio.users.list')->with('success', 'Credencial criada com sucesso!');
    }


    // Listar todos os usuários
    public function listUsers()
    {
        $relatorioUsers = RelatorioUser::all();

        return view('Modulos.RelatorioFechamento.Users.list', compact('relatorioUsers'));
    }

    // Atualizar usuário
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

    // Excluir o usuário
    public function destroyUser($id)
    {
        $user = RelatorioUser::findOrFail($id);
        $user->delete();
        return redirect()->route('relatorio.users')->with('success', 'Credenciais excluídas com sucesso!');
    }
}
