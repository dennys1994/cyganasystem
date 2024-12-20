<x-app-layout>
    <div class="max-w-2xl mx-auto mt-8 bg-gray-800 p-6 rounded-lg shadow-md">
        <form action="{{ route('funcao.update', $funcaoPat->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="nome" class="block text-sm font-medium text-gray-300">Nome da Função:</label>
                <input type="text" name="nome" id="nome" value="{{ $funcaoPat->nome }}" required
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-md shadow-sm">
                @error('nome')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4">
                <button type="submit" 
                    class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700">
                    Atualizar Função
                </button>
            </div>
        </form>

        <a href="{{ route('funcao.index') }}" class="mt-6 inline-block w-full bg-blue-600 py-3 px-6 text-white rounded-md">
            Voltar
        </a>
    </div>
</x-app-layout>
