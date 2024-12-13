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

        <!-- Iterando sobre as bandeiras -->
        @foreach($bandeiras as $bandeira)
            <div class="bg-gray-700 p-6 rounded-lg shadow-md mb-6">
                <!-- Nome da bandeira -->
                <h3 class="text-2xl font-semibold text-white">{{ $bandeira->nome }}</h3>
                
                <!-- Botões de Ação para Bandeira -->
                <div class="mt-4 flex space-x-4">
                    <!-- Editar -->
                    <a href="{{ route('bandeiras.edit', $bandeira->id) }}" 
                       class="inline-block py-2 px-4 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        Editar
                    </a>
                    <!-- Excluir -->
                    <form action="{{ route('bandeiras.destroy', $bandeira->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                            class="inline-block py-2 px-4 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                            Excluir
                        </button>
                    </form>
                </div>
                
                <!-- Exibição das taxas associadas -->
                <div class="mt-6">
                    <h4 class="text-xl font-semibold text-gray-300">Taxas</h4>
                    <ul class="mt-4 text-gray-300">
                        @foreach($bandeira->taxas as $taxa)
                            <li class="flex justify-between py-2">
                                <span>{{ $taxa->parcelas }}x:</span> 
                                <span>{{ $taxa->percentual }}%</span>

                                <!-- Botões de Ação para Taxa -->
                                <div class="flex space-x-2">
                                    <!-- Editar -->
                                    <a href="{{ route('taxas.edit', $taxa->id) }}" 
                                       class="inline-block py-1 px-3 bg-yellow-600 text-white font-semibold rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50">
                                        Editar
                                    </a>
                                    <!-- Excluir -->
                                    <form action="{{ route('taxas.destroy', $taxa->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="inline-block py-1 px-3 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Formulário para adicionar nova taxa -->
                <form action="{{ route('taxas.store') }}" method="POST" class="mt-6 space-y-4">
                    @csrf
                    <input type="hidden" name="bandeira_id" value="{{ $bandeira->id }}">
                    
                    <div>
                        <label for="parcelas" class="block text-sm font-medium text-gray-300">Parcelas:</label>
                        <input type="number" name="parcelas" placeholder="Número de Parcelas" 
                               class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none">
                    </div>

                    <div>
                        <label for="percentual" class="block text-sm font-medium text-gray-300">Percentual:</label>
                        <input type="text" name="percentual" placeholder="Percentual (%)" 
                               class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none">
                    </div>

                    <button type="submit" 
                            class="w-full py-2 px-4 bg-green-600 text-white font-semibold rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                        Adicionar Taxa
                    </button>
                </form>
            </div>
        @endforeach

        <!-- Link para voltar -->
        <a href="{{ route('calculadora.funcoes') }}" 
           class="inline-block w-full max-w-xs py-3 px-6 text-center text-white font-semibold bg-blue-600 rounded-md shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-400 transition-all duration-300 ease-in-out mt-6">
            Voltar
        </a>
    </div>
</x-app-layout>
