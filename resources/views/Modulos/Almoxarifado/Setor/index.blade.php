<x-app-layout>
    <div class="max-w-4xl mx-auto mt-8 bg-gray-800 p-6 rounded-lg shadow-md">
        <!-- Exibição de mensagem de sucesso -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Exibição de mensagem de erro -->
        @if (session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Link para a página de criação de novo setor -->
        <a href="{{ route('setores.create') }}" 
           class="inline-block py-2 px-4 mb-4 text-white font-semibold bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
            Adicionar Novo Setor
        </a>

        <!-- Tabela de setores -->
        <table class="min-w-full bg-gray-700 rounded-lg shadow-md">
            <thead>
                <tr class="bg-gray-600 text-white">
                    <th class="px-6 py-3 text-left">Nome do Setor</th>
                    <th class="px-6 py-3 text-left">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($setores as $setor)
                    <tr class="border-t border-gray-600">
                        <td class="px-6 py-3 text-gray-300">{{ $setor->nome }}</td>
                        <td class="px-6 py-3">
                            <a href="{{ route('setores.edit', $setor->id) }}" class="text-blue-500 hover:text-blue-700">Editar</a> |
                            <form action="{{ route('setores.destroy', $setor->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este setor?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Link para voltar -->
        <a href="{{ route('almoxarifado.functions') }}" 
           class="inline-block py-2 px-4 mt-6 text-white font-semibold bg-blue-600 rounded-md shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-400">
            Voltar
        </a>
    </div>
</x-app-layout>
