<x-app-layout>
    <div class="container mx-auto p-6 bg-gray-800 text-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold text-gray-200 mb-6">Criar Patrimônio</h1>

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

        <form action="{{ route('almoxarifado.store') }}" method="POST">
            @csrf
            <!-- Setor -->
            <div class="mb-6">
                <label for="setor_pat_id" class="block text-sm font-medium text-gray-300">Setor</label>
                <select name="setor_pat_id" id="setor_pat_id" class="mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md text-black focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Selecione um setor</option>
                    @foreach($setores as $setor)
                        <option value="{{ $setor->id }}" {{ old('setor_pat_id') == $setor->id ? 'selected' : '' }}>{{ $setor->nome }}</option>
                    @endforeach
                </select>
                @error('setor_pat_id')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tipo de Patrimônio -->
            <div class="mb-6">
                <label for="tipo_pat" class="block text-sm font-medium text-gray-300">Tipo de Patrimônio</label>
                <select name="tipo_pat" id="tipo_pat" class="mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md text-black focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Selecione um tipo</option>
                    <option value="1" {{ old('tipo_pat') == 1 ? 'selected' : '' }}>Equipamento</option>
                    <option value="2" {{ old('tipo_pat') == 2 ? 'selected' : '' }}>Ferramenta</option>
                </select>
                @error('tipo_pat')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>


            <!-- Função -->
            <div class="mb-6">
                <label for="nova_funcao" class="block text-sm font-medium text-gray-300">Função</label>
                <input type="text" id="nova_funcao" name="nova_funcao" class="mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md text-black focus:ring-indigo-500 focus:border-indigo-500" placeholder="Digite a função">
                <div id="funcao_suggestions" class="mt-2"></div>
                @error('nova_funcao')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tamanho -->
            <div class="mb-6">
                <label for="novo_tamanho" class="block text-sm font-medium text-gray-300">Tamanho</label>
                <input type="text" id="novo_tamanho" name="novo_tamanho" class="mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md text-black focus:ring-indigo-500 focus:border-indigo-500" placeholder="Digite o tamanho">
                <div id="tamanho_suggestions" class="mt-2"></div>
                @error('novo_tamanho')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

                
            <!-- Nome Completo -->
            <div class="mb-6">
                <label for="nome_completo" class="block text-sm font-medium text-gray-300">Nome Completo</label>
                <input type="text" name="nome_completo" id="nome_completo" class="mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md text-black focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('nome_completo') }}" required>
                @error('nome_completo')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Quantidade de Séries -->
            <div class="mb-6">
                <label for="series" class="block text-sm font-medium text-gray-300">Quantidade de Séries</label>
                <input type="number" name="series" id="series" class="mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md text-black focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('series') }}" min="1" required>
                @error('series')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            

            <!-- Botão de Submissão -->
            <div class="mt-6">
                <button type="submit" class="w-full py-3 px-6 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 text-black focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Criar Patrimônio
                </button>
            </div>
        </form>

        <a href="{{ route('almoxarifado.index') }}" class="inline-block w-full max-w-xs py-3 px-6 text-center text-white font-semibold bg-gray-600 rounded-md shadow-lg hover:bg-gray-700 mt-4 text-black focus:outline-none focus:ring-4 focus:ring-indigo-400">
            Voltar
        </a>
    </div>
</x-app-layout>
<script>
    // Função de autocomplete para a função
    const funcoes = @json($funcoes); // Converte a variável PHP para JavaScript
    const tamanhos = @json($tamanhos);
    
    document.getElementById('nova_funcao').addEventListener('input', function() {
        let input = this.value.toLowerCase();
        let suggestionsContainer = document.getElementById('funcao_suggestions');
        suggestionsContainer.innerHTML = ''; // Limpa as sugestões anteriores
    
        if (input.length > 2) {
            // Filtra as funções baseadas no que foi digitado
            let filteredFuncoes = funcoes.filter(funcao => funcao.nome.toLowerCase().includes(input));
    
            if (filteredFuncoes.length > 0) {
                filteredFuncoes.forEach(funcao => {
                    let suggestionItem = document.createElement('div');
                    suggestionItem.textContent = funcao.nome;
                    suggestionItem.classList.add('suggestion-item');
                    suggestionItem.onclick = () => selectFuncao(funcao);
                    suggestionsContainer.appendChild(suggestionItem);
                });
            } else {
                suggestionsContainer.innerHTML = 'Nenhuma função encontrada.';
            }
        }
    });
    
    // Função para selecionar uma sugestão de função
    function selectFuncao(funcao) {
        document.getElementById('nova_funcao').value = funcao.nome;
        document.getElementById('funcao_suggestions').innerHTML = '';
    }
    
    // Função de autocomplete para o tamanho
    document.getElementById('novo_tamanho').addEventListener('input', function() {
        let input = this.value.toLowerCase();
        let suggestionsContainer = document.getElementById('tamanho_suggestions');
        suggestionsContainer.innerHTML = ''; // Limpa as sugestões anteriores
    
        if (input.length > 2) {
            // Filtra os tamanhos baseados no que foi digitado
            let filteredTamanhos = tamanhos.filter(tamanho => tamanho.tamanho.toLowerCase().includes(input));
    
            if (filteredTamanhos.length > 0) {
                filteredTamanhos.forEach(tamanho => {
                    let suggestionItem = document.createElement('div');
                    suggestionItem.textContent = tamanho.tamanho;
                    suggestionItem.classList.add('suggestion-item');
                    suggestionItem.onclick = () => selectTamanho(tamanho);
                    suggestionsContainer.appendChild(suggestionItem);
                });
            } else {
                suggestionsContainer.innerHTML = 'Nenhum tamanho encontrado.';
            }
        }
    });
    
    // Função para selecionar uma sugestão de tamanho
    function selectTamanho(tamanho) {
        document.getElementById('novo_tamanho').value = tamanho.tamanho;
        document.getElementById('tamanho_suggestions').innerHTML = '';
    }
    </script>
    