<x-app-layout>
    <div class="max-w-2xl mx-auto mt-8 bg-gray-800 p-6 rounded-lg shadow-md">
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('funcao.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="nome" class="block text-sm font-medium text-gray-300">Nome da Função:</label>
                <input type="text" name="nome" id="nome" placeholder="Digite o nome da função" required
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-md shadow-sm">
                @error('nome')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4">
                <button type="submit" 
                    class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700">
                    Cadastrar Função
                </button>
            </div>
        </form>

        <a href="{{ route('funcao.index') }}" class="mt-6 inline-block w-full bg-blue-600 py-3 px-6 text-white rounded-md">
            Voltar
        </a>
    </div>
</x-app-layout>
