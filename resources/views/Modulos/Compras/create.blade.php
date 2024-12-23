<x-app-layout>
    <div class="container mx-auto p-6 bg-gray-800 text-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold text-gray-200 mb-6">Adicionar Item à Lista de Compras</h1>

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

        <form action="{{ route('shopping_lists.store') }}" method="POST">
            @csrf

            <!-- Campo para Descrição -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-300">Descrição</label>
                <input type="text" name="description" id="description" 
                    class="mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md text-black focus:ring-indigo-500 focus:border-indigo-500" 
                    placeholder="Digite o nome do item" value="{{ old('description') }}" required>
                @error('description')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Botão de Submissão -->
            <div class="mt-6">
                <button type="submit" 
                    class="w-full py-3 px-6 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 text-black focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Adicionar
                </button>
            </div>
        </form>

        <a href="{{ route('shopping_lists.index') }}" 
            class="inline-block w-full max-w-xs py-3 px-6 text-center text-white font-semibold bg-gray-600 rounded-md shadow-lg hover:bg-gray-700 mt-4 text-black focus:outline-none focus:ring-4 focus:ring-indigo-400">
            Voltar
        </a>
    </div>
</x-app-layout>
