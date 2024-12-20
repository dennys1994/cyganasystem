<x-app-layout>
    <div class="max-w-7xl mx-auto mt-8 bg-gray-800 p-6 rounded-lg shadow-md">

        <!-- Exibição de mensagens de sucesso -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Exibição de mensagens de erro -->
        @if (session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <h2 class="text-2xl font-bold text-white">Lista de Grupos de Patrimônio</h2>
        <a href="{{ route('grupo_patrimonios.create') }}" class="bg-indigo-600 text-white py-2 px-4 rounded mt-4 inline-block">
            Adicionar Grupo
        </a>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Nome do Grupo</th>
                        <th scope="col" class="px-6 py-3">Setor</th>
                        <th scope="col" class="px-6 py-3">Estado</th>
                        <th scope="col" class="px-6 py-3 w-64">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($grupos as $grupo)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <td class="px-6 py-4">{{ $grupo->id }}</td>
                            <td class="px-6 py-4">{{ $grupo->nome }}</td>
                            <td class="px-6 py-4">{{ $grupo->setor->nome ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $grupo->estado }}</td>
                            <td class="px-6 py-4 flex space-x-2">
                                <a href="{{ route('grupo_patrimonios.edit', $grupo->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Editar</a>
                                
                                <!-- Novo botão para adicionar patrimônio -->
                                <a href="{{ route('grupo_patrimonios.adicionarPatrimonio', $grupo->id) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Adicionar</a>

                                <!-- Novo botão para listar ferramentas -->
                                <a href="{{ route('grupo_patrimonios.ferramentas', $grupo->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Listar Ferramentas</a>

                                <form action="{{ route('grupo_patrimonios.destroy', $grupo->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este grupo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <a href="{{ route('almoxarifado.functions') }}" class="inline-block py-2 px-4 mt-6 text-white font-semibold bg-blue-600 rounded-md shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-400">
            Voltar
        </a>
    </div>
</x-app-layout>
