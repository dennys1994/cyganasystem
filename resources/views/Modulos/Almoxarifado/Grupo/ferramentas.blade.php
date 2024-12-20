<x-app-layout>
    <div class="max-w-7xl mx-auto mt-8 bg-gray-800 p-6 rounded-lg shadow-md">

        <h2 class="text-2xl font-bold text-white">Ferramentas do Grupo: {{ $grupo->nome }}</h2>
        
        @if($itens->isEmpty())
            <p class="text-white">Não há ferramentas associadas a este grupo.</p>
        @else
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nome Completo</th>
                        <th scope="col" class="px-6 py-3">Número de Série</th>
                        <th scope="col" class="px-6 py-3">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($itens as $item)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <td class="px-6 py-4">{{ $item->nome }}</td>
                            <td class="px-6 py-4">{{ $item->serie }}</td>   
                            <td class="px-6 py-4 flex space-x-2">
                                <!-- Botão de Excluir -->
                                <form action="{{ route('grupo_patrimonios.deleteItem', ['grupo' => $grupo->id, 'item' => $item->id]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta ferramenta?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Excluir</button>
                                </form>                                
                            </td>                         
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('grupo_patrimonios.index') }}" class="inline-block py-2 px-4 mt-6 text-white font-semibold bg-blue-600 rounded-md shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-400">
            Voltar
        </a>
    </div>
</x-app-layout>
