<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6 text-white">Credenciais Cadastradas</h1>
        <p class="text-lg text-center mb-6 text-gray-400">Aqui estão todas as credenciais cadastradas. Você pode editar ou excluir conforme necessário.</p>

        <!-- Mensagem de Sucesso ou Erro -->
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded-lg">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tabela de Credenciais -->
        <div class="overflow-x-auto bg-gray-800 rounded-lg shadow-md">
            <table class="min-w-full table-auto text-gray-300">
                <thead>
                    <tr class="bg-gray-700">
                        <th class="py-3 px-6 text-left">Nome</th>
                        <th class="py-3 px-6 text-left">E-mail</th>
                        <th class="py-3 px-6 text-left">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($relatorioUsers as $user)
                        <tr class="bg-gray-800 hover:bg-gray-700">
                            <td class="py-3 px-6">{{ $user->name }}</td>
                            <td class="py-3 px-6">{{ $user->email }}</td>
                            <td class="py-3 px-6 flex space-x-4">
                                <!-- Botão de Editar -->
                                <a href="{{ route('relatorio.users.edit', $user->id) }}" class="text-yellow-500 hover:text-yellow-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                      </svg>                                      
                                </a>
                                <!-- Botão de Excluir -->
                                <form action="{{ route('relatorio.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta credencial?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
