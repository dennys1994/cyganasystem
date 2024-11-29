<x-app-layout>
    <div class="container mx-auto p-6 bg-gray-800 text-black rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold text-gray-200 mb-6">Criar Faixa de Preço</h1>
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
        <form action="{{ route('margem.store_faixa') }}" method="POST">
            @csrf

            <!-- Tabela de Margem -->
            <div class="mb-6">
                <label for="categoria_id" class="block text-sm font-medium text-gray-300">Tabela de Margem</label>
                <select name="categoria_id" id="categoria_id" class="mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Selecione uma Tabela</option>
                    @foreach($tabelas as $tabela)
                        <option value="{{ $tabela->id }}">{{ $tabela->nome }}</option>
                    @endforeach
                </select>
                @error('categoria_id')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Faixa Inicial (min) -->
            <div class="mb-6">
                <label for="min" class="block text-sm font-medium text-gray-300">Faixa Inicial</label>
                <input type="number" name="min" id="min" class="mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>

            <!-- Faixa Final (max) -->
            <div class="mb-6">
                <label for="max" class="block text-sm font-medium text-gray-300">Faixa Final</label>
                <input type="number" name="max" id="max" class="mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>

            <!-- Percentual de Margem (avista e parcelado) -->
            <div class="mb-6">
                <label for="avista" class="block text-sm font-medium text-gray-300">Percentual de Margem (À Vista)</label>
                <input type="number" name="avista" id="avista" class="mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>

            <div class="mb-6">
                <label for="parcelado" class="block text-sm font-medium text-gray-300">Percentual de Margem (Parcelado)</label>
                <input type="number" name="parcelado" id="parcelado" class="mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>

            <!-- Botão -->
            <div class="mt-6">
                <button type="submit" class="w-full py-3 px-6 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Criar Faixa
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
