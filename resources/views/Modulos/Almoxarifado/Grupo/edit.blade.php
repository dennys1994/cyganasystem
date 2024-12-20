<x-app-layout>
    <div class="max-w-7xl mx-auto mt-8 bg-gray-800 p-6 rounded-lg shadow-md">
        
        <!-- Exibição de mensagem de sucesso -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="text-2xl font-bold text-white">Editar Grupo de Patrimônio</h2>

        <!-- Formulário de edição -->
        <form action="{{ route('grupo_patrimonios.update', $grupo->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="nome" class="block text-sm font-medium text-gray-300">Nome do Grupo:</label>
                <input type="text" name="nome" id="nome" value="{{ old('nome', $grupo->nome) }}" placeholder="Digite o nome do grupo" required
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-md shadow-sm">
                @error('nome')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="id_setor" class="block text-sm font-medium text-gray-300">Setor:</label>
                <select name="id_setor" id="id_setor" required
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-md shadow-sm">
                    <option value="" disabled selected>Selecione um setor</option>
                    @foreach ($setores as $setor)
                        <option value="{{ $setor->id }}" {{ $grupo->id_setor == $setor->id ? 'selected' : '' }}>
                            {{ $setor->nome }}
                        </option>
                    @endforeach
                </select>
                @error('id_setor')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="pt-4">
                <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700">
                    Atualizar Grupo
                </button>
            </div>
        </form>

        <a href="{{ route('grupo_patrimonios.index') }}" class="mt-6 inline-block w-full bg-blue-600 py-3 px-6 text-white rounded-md">
            Voltar
        </a>
    </div>
</x-app-layout>
