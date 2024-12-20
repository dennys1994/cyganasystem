<x-app-layout>
    <div class="max-w-6xl mx-auto mt-8 bg-gray-800 p-6 rounded-lg shadow-md">
        <!-- Exibição de mensagem de sucesso -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="text-2xl font-bold text-white mb-4">Tamanhos de Patrimônio</h2>

        <a href="{{ route('tamanho.create') }}" class="bg-indigo-600 text-white py-2 px-4 rounded mb-4 inline-block">
            Adicionar Tamanho
        </a>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Tamanho</th>
                        <th scope="col" class="px-6 py-3">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tamanhoPats as $tamanhoPat)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $tamanhoPat->id }}</td>
                            <td class="px-6 py-4">{{ $tamanhoPat->tamanho }}</td>
                            <td class="px-6 py-4 flex items-center space-x-4">
                                <a href="{{ route('tamanho.edit', $tamanhoPat->id) }}" class="bg-yellow-500 py-1 px-3 rounded text-black hover:bg-yellow-400">
                                    Editar
                                </a>
                                <form action="{{ route('tamanho.destroy', $tamanhoPat->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 py-1 px-3 rounded text-white hover:bg-red-400">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Link para voltar -->
        <a href="{{ route('almoxarifado.functions') }}" 
           class="inline-block py-2 px-4 mt-6 text-white font-semibold bg-blue-600 rounded-md shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-400">
            Voltar
        </a>
    </div>
</x-app-layout>
