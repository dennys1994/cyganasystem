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
        
        <h2 class="text-2xl font-bold text-white">Lista de Patrimônios</h2>
        <a href="{{ route('almoxarifado.create') }}" class="bg-indigo-600 text-white py-2 px-4 rounded mt-4 inline-block">
            Adicionar Patrimônio
        </a>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Código</th>
                        <th scope="col" class="px-6 py-3">Cód Item</th>
                        <th scope="col" class="px-6 py-3">Nome Completo</th>
                        <th scope="col" class="px-6 py-3">Setor</th>
                        <th scope="col" class="px-6 py-3">Função</th>
                        <th scope="col" class="px-6 py-3">Tamanho</th>
                        <th scope="col" class="px-6 py-3 w-64">Ações</th> <!-- Altere a largura da coluna -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patrimonios as $patrimonio)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <td class="px-6 py-4">{{ $patrimonio->id }}</td>
                            <td class="px-6 py-4">{{ $patrimonio->codigo }}</td>
                            <td class="px-6 py-4">{{ $patrimonio->nome_abv }}</td>
                            <td class="px-6 py-4">{{ $patrimonio->nome_completo }}</td>
                            <td class="px-6 py-4">{{ $patrimonio->setorPat->nome ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $patrimonio->funcaoPat->nome ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $patrimonio->tamanhoPat->tamanho ?? '-' }}</td>
                            <td class="px-6 py-4 flex space-x-2"> <!-- Usando flexbox para alinhar os botões -->
                                <a href="{{ route('almoxarifado.edit', $patrimonio->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Editar</a>
                                <form action="{{ route('almoxarifado.destroy', $patrimonio->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este patrimônio?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Excluir</button>
                                </form>
                                
                                <a href="{{ route('patrimonio.barcode', $patrimonio->id) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 ml-2 flex items-center">
                                    <svg class="w-[17px] h-[17px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M2.9917 4.9834V18.917M9.96265 4.9834V18.917M15.9378 4.9834V18.917m2.9875-13.9336V18.917"/>
                                        <path stroke="currentColor" stroke-linecap="round" d="M5.47925 4.4834V19.417m1.9917-14.9336V19.417M21.4129 4.4834V19.417M13.4461 4.4834V19.417"/>
                                    </svg>
                                    Gerar
                                </a>
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
