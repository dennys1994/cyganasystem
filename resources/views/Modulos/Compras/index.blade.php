<x-app-layout>
    <div class="max-w-7xl mx-auto mt-8 bg-gray-800 p-6 rounded-lg shadow-md">

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

        <h2 class="text-2xl font-bold text-white">Lista de Compras</h2>
        <div class="flex space-x-4 mt-4">
            <a href="{{ route('shopping_lists.create') }}" class="bg-indigo-600 text-white py-2 px-4 rounded inline-block">
                Adicionar Item à Lista
            </a>
            <a href="{{ route('shopping_lists.generate_pdf') }}" target="_blank" class="bg-green-600 text-white py-2 px-4 rounded inline-block">
                Gerar PDF
            </a>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Descrição</th>
                        <th scope="col" class="px-6 py-3">Usuário Solicitante</th>
                        <th scope="col" class="px-6 py-3">Setor</th>
                        <th scope="col" class="px-6 py-3">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($compras as $compra)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <td class="px-6 py-4">{{ $compra->id }}</td>
                            <td class="px-6 py-4">{{ $compra->description }}</td>
                            <td class="px-6 py-4">{{ $compra->user->name ?? 'Desconhecido' }}</td>
                            <td class="px-6 py-4">{{ $compra->user->role->name ?? 'Desconhecido' }}</td>
                            <td class="px-6 py-4 flex space-x-2">
                                @if (auth()->id() === $compra->user_id || auth()->user()->role->id === 1)
                                    <form action="{{ route('shopping_lists.destroy', $compra->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Excluir</button>
                                    </form>
                                @else
                                    <span class="text-gray-400 italic">Sem permissão</span>
                                @endif
                            </td>                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <a href="{{ route('dashboard') }}" class="inline-block py-2 px-4 mt-6 text-white font-semibold bg-blue-600 rounded-md shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-400">
            Voltar
        </a>
    </div>
</x-app-layout>

