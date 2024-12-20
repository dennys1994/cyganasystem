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
   
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Código da Série</th>
                        <th scope="col" class="px-6 py-3">Nome da Série</th>
                        <th scope="col" class="px-6 py-3">Estado</th>
                        <th scope="col" class="px-6 py-3">Setor</th>
                        <th scope="col" class="px-6 py-3">Função</th>
                        <th scope="col" class="px-6 py-3">Tamanho</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patrimonios as $patr)
                        @php
                            // Decodifica o JSON 'series' para um array
                            $series = !empty($patr->series) ? json_decode($patr->series) : [];
                        @endphp
                
                        @foreach ($series as $serie)
                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <td class="px-6 py-4">{{ $serie->codigo ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $patr->nome_completo ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $serie->estado ?? '-' }}</td>                      
                                <td class="px-6 py-4">{{ $patr->setorPat->nome ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $patr->funcaoPat->nome ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $patr->tamanhoPat->tamanho ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
                               
            </table>
        </div>
        <a href="{{ route('almoxarifado.functions') }}" class="inline-block py-2 px-4 mt-6 text-white font-semibold bg-blue-600 rounded-md shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-400">
            Voltar
        </a>
    </div>
</x-app-layout>
