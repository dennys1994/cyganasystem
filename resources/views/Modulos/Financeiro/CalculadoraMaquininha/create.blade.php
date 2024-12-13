<x-app-layout>
    <div class="max-w-2xl mx-auto mt-8 bg-gray-800 p-6 rounded-lg shadow-md">
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

        <!-- Formulário para cadastrar nova bandeira -->
        <form action="{{ route('bandeiras.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Campo de nome da bandeira -->
            <div>
                <label for="nome" class="block text-sm font-medium text-gray-300">Nome da Bandeira:</label>
                <input type="text" name="nome" id="nome" placeholder="Digite o nome da bandeira" required
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none">
                @error('nome')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botão de Enviar -->
            <div class="pt-4">
                <button type="submit" 
                    class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                    Cadastrar Bandeira
                </button>
            </div>
        </form>

        <!-- Link para voltar -->
        <a href="{{ route('bandeiras.index') }}" 
           class="inline-block w-full max-w-xs py-3 px-6 text-center text-white font-semibold bg-blue-600 rounded-md shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-400 transition-all duration-300 ease-in-out mt-6">
            Voltar
        </a>
    </div>
</x-app-layout>
