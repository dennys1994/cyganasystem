<x-app-layout>
    <div class="container mx-auto p-6 bg-gray-800 text-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold text-gray-200 mb-6">Editar Patrimônio</h1>

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

        <form action="{{ route('almoxarifado.update', $patrimonio->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nome Abreviado -->
            <div class="mb-6">
                <label for="nome_abv" class="block text-sm font-medium text-gray-300">Nome Abreviado</label>
                <input type="text" name="nome_abv" id="nome_abv" class="text-black mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('nome_abv', $patrimonio->nome_abv) }}" required>
                @error('nome_abv')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nome Completo -->
            <div class="mb-6">
                <label for="nome_completo" class="block text-sm font-medium text-gray-300">Nome Completo</label>
                <input type="text" name="nome_completo" id="nome_completo" class="text-black mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('nome_completo', $patrimonio->nome_completo) }}" required>
                @error('nome_completo')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Quantidade de Séries -->
            <div class="mb-6">
                <label for="series" class="block text-sm font-medium text-gray-300">Quantidade de Séries</label>
                <input type="number" name="series" id="series" class="text-black mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('series', count(json_decode($patrimonio->series))) }}" min="1" required>
                @error('series')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Setor -->
            <div class="mb-6">
                <label for="setor_pat_id" class="block text-sm font-medium text-gray-300">Setor</label>
                <select name="setor_pat_id" id="setor_pat_id" class="text-black mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Selecione um setor</option>
                    @foreach($setores as $setor)
                        <option value="{{ $setor->id }}" {{ old('setor_pat_id', $patrimonio->setor_pat_id) == $setor->id ? 'selected' : '' }}>{{ $setor->nome }}</option>
                    @endforeach
                </select>
                @error('setor_pat_id')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Função -->
            <div class="mb-6">
                <label for="funcao_pat_id" class="block text-sm font-medium text-gray-300">Função</label>
                <select name="funcao_pat_id" id="funcao_pat_id" class="text-black mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Selecione uma função</option>
                    @foreach($funcoes as $funcao)
                        <option value="{{ $funcao->id }}" {{ old('funcao_pat_id', $patrimonio->funcao_pat_id) == $funcao->id ? 'selected' : '' }}>{{ $funcao->nome }}</option>
                    @endforeach
                </select>
                @error('funcao_pat_id')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tamanho -->
            <div class="mb-6 text-black">
                <label for="tamanho_pat_id" class="block text-sm font-medium text-gray-300">Tamanho</label>
                <select name="tamanho_pat_id" id="tamanho_pat_id" class="text-black mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Selecione um tamanho</option>
                    @foreach($tamanhos as $tamanho)
                        <option value="{{ $tamanho->id }}" {{ old('tamanho_pat_id', $patrimonio->tamanho_pat_id) == $tamanho->id ? 'selected' : '' }}>{{ $tamanho->tamanho }}</option>
                    @endforeach
                </select>
                @error('tamanho_pat_id')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Botão de Submissão -->
            <div class="mt-6">
                <button type="submit" class="w-full py-3 px-6 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Atualizar Patrimônio
                </button>
            </div>
        </form>

        <a href="{{ route('almoxarifado.index') }}" class="inline-block w-full max-w-xs py-3 px-6 text-center text-white font-semibold bg-gray-600 rounded-md shadow-lg hover:bg-gray-700 mt-4 focus:outline-none focus:ring-4 focus:ring-indigo-400">
            Voltar
        </a>
    </div>
</x-app-layout>
