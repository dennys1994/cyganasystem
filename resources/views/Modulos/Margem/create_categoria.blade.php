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

        <!-- Formulário para criar categoria de margem -->
        <form action="{{ route('margem.store_categoria') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Campo de nome da categoria -->
            <div>
                <label for="nome" class="block text-sm font-medium text-gray-300">Nome da Categoria:</label>
                <input type="text" name="nome" id="nome" required
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none">
                @error('nome')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Campo de descrição (opcional) -->
            <div>
                <label for="descricao" class="block text-sm font-medium text-gray-300">Descrição:</label>
                <textarea name="descricao" id="descricao" 
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none" 
                    rows="5"></textarea>
                @error('descricao')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="maodeobra_fixo" class="block text-sm font-medium text-gray-300">Mão de Obra Fixa</label>
                <div class="flex">
                    <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                        R$
                    </span>
                    <input type="number" step="0.01" id="maodeobra_fixo" name="maodeobra_fixo" 
                           value="0" 
                           class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
            </div>
            
            
            <!-- Botão de Enviar -->
            <div class="pt-4">
                <button type="submit" 
                    class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                    Criar Categoria
                </button>
            </div>
        </form>
        <a href="{{route('margem.index')}}"
            class="inline-block w-full max-w-xs py-3 px-6 text-center text-white font-semibold bg-blue-600 rounded-md shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-400 transition-all duration-300 ease-in-out"
            style="margin-top: 10px;">
                {{ __('Voltar') }}
        </a>
    </div>
</x-app-layout>
