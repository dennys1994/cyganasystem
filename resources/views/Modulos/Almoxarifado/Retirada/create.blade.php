<x-app-layout>
    <div class="max-w-2xl mx-auto mt-8 bg-gray-800 p-6 rounded-lg shadow-md">
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="text-2xl font-bold text-white mb-6">Criar Retirada de Patrimônios</h1>

        <form action="{{ route('retiradas.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Responsável pela Retirada -->
            <div class="mb-4">
                <label for="id_user_resp" class="block text-white">Responsável pela Retirada:</label>
                <input type="text" id="id_user_resp_display" class="w-full p-2 mt-2 rounded bg-gray-200 text-gray-800"
                       value="{{ auth()->user()->name }}" readonly>
                <input type="hidden" name="id_user_resp" id="id_user_resp" value="{{ auth()->user()->id }}">
            </div>

            <div class="mb-4">
                <label for="id_user_tec" class="block text-white">Técnico Responsável:</label>
                <select name="id_user_tec" id="id_user_tec" class="w-full p-2 mt-2 rounded">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Campo de Busca para Patrimônios -->
            <div class="mb-4">
                <label for="search_patrimonio" class="block text-white">Buscar Patrimônio:</label>
                <input type="text" id="search_patrimonio" class="w-full p-2 mt-2 rounded bg-gray-700 text-white" 
                       placeholder="Digite o código ou nome do patrimônio">
                <div id="patrimonio-results" class="mt-2 space-y-2 hidden"></div>
            </div>

            <!-- Lista de Patrimônios Disponíveis para Seleção -->
            <div class="mt-6">
                <h2 class="text-xl text-white">Selecione os Patrimônios</h2>
                <div id="patrimonio-list" class="space-y-2">
                    @foreach ($patrimonio as $patr)                        
                        @php
                            // Verifica se 'series' não está vazio e decodifica
                            $series = !empty($patr->series) ? json_decode($patr->series) : [];
                        @endphp
                        <div class="patrimonio-item">
                            @foreach ($series as $serie)
                                @if ($serie->estado === 'disponivel') <!-- Exibe apenas séries com estado 'disponivel' -->
                                    <div class="flex items-center patrimonio-data" data-nome="{{ $patr->nome_completo }}" data-codigo="{{ $serie->codigo }}">
                                        <input type="checkbox" id="patrimonio_{{ $patr->id }}_serie_{{ $serie->codigo }}" name="patrimonios[]" value="{{ $serie->codigo }}" class="mr-2 patrimonio-checkbox" data-codigo-serie="{{ $serie->codigo }}">
                                        <label for="patrimonio_{{ $patr->id }}_serie_{{ $serie->codigo }}" class="text-white">
                                            {{ $patr->nome_completo }} - Código: {{ $serie->codigo }}
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Campo de Busca para Grupos -->
            <div class="mb-4">
                <label for="search_grupo" class="block text-white">Buscar Grupo:</label>
                <input type="text" id="search_grupo" class="w-full p-2 mt-2 rounded bg-gray-700 text-white" 
                       placeholder="Digite o ID do grupo">
                <div id="grupo-results" class="mt-2 space-y-2 hidden"></div>
            </div>

            <!-- Lista de Grupos de Patrimônios -->
            <div class="mt-6">
                <h2 class="text-xl text-white">Selecione os Grupos</h2>
                <div id="grupo-list" class="space-y-2">
                    @foreach ($grupo as $g)
                        @if ($g->estado === 'disponivel') 
                            <div class="grupo-item" data-id="{{ $g->id }}" data-nome="{{ $g->nome }}">
                                <input type="checkbox" name="grupos[]" value="{{ $g->id }}" class="mr-2 grupo-checkbox">
                                <label for="grupo_{{ $g->id }}" class="text-white">{{ $g->nome }}</label>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Campo de Anotações -->
            <div class="mb-4">
                <label for="anotacoes" class="block text-white">Anotações:</label>
                <textarea name="anotacoes" id="anotacoes" rows="4" class="w-full p-2 mt-2 rounded bg-gray-700 text-white" placeholder="Digite suas anotações...">{{ old('anotacoes') }}</textarea>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700">
                    Criar Retirada
                </button>
            </div>
        </form>

        <a href="{{ route('retiradas.index') }}" class="mt-6 inline-block w-full bg-blue-600 py-3 px-6 text-white text-center rounded-md hover:bg-blue-700">
            Voltar
        </a>
    </div>

    <script>
        // Busca de Grupos
        document.getElementById('search_grupo').addEventListener('input', function () {
            let query = this.value.toLowerCase();
            let items = document.querySelectorAll('.grupo-item');
            let results = document.getElementById('grupo-results');
            results.innerHTML = ''; // Limpa os resultados anteriores
            results.classList.add('hidden');

            items.forEach(function (item) {
                let nome = item.getAttribute('data-nome').toLowerCase();

                if (nome.includes(query)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        document.getElementById('search_patrimonio').addEventListener('input', function () {
            let searchQuery = this.value.toLowerCase().replace(/-/g, ''); // Remove hífens da pesquisa
            let patrimonioItems = document.querySelectorAll('.patrimonio-data');
    
            patrimonioItems.forEach(function (item) {
                let nome = item.getAttribute('data-nome').toLowerCase();
                let codigo = item.getAttribute('data-codigo').toLowerCase().replace(/-/g, ''); // Remove hífens do código
    
                if (nome.includes(searchQuery) || codigo.includes(searchQuery)) {
                    item.style.display = ''; // Exibe o item
                } else {
                    item.style.display = 'none'; // Oculta o item
                }
            });
        });
    
        document.getElementById('search_patrimonio').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Impede o recarregamento da página ao pressionar Enter
    
                let searchQuery = this.value.toLowerCase().replace(/-/g, ''); // Remove hífens da pesquisa
                let patrimonioItems = document.querySelectorAll('.patrimonio-data');
    
                let itemFound = false;
    
                patrimonioItems.forEach(function (item) {
                    let nome = item.getAttribute('data-nome').toLowerCase();
                    let codigo = item.getAttribute('data-codigo').toLowerCase().replace(/-/g, ''); // Remove hífens do código
    
                    if ((nome.includes(searchQuery) || codigo.includes(searchQuery)) && !itemFound) {
                        // Marca o checkbox do primeiro item encontrado
                        item.querySelector('input[type="checkbox"]').checked = true;
                        itemFound = true; // Apenas marca o primeiro item encontrado
                    }
                });
            }
        });
    
        // Script para marcos de seleção
        document.addEventListener('DOMContentLoaded', function ()  {
            const checkboxes = document.querySelectorAll('.patrimonio-checkbox');
            const seriesSelecionados = document.getElementById('seriesSelecionados');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    let seriesArray = seriesSelecionados.value ? seriesSelecionados.value.split(',') : [];

                    if (this.checked) {
                        if (!seriesArray.includes(this.dataset.codigoSerie)) {
                            seriesArray.push(this.dataset.codigoSerie);
                        }
                    } else {
                        seriesArray = seriesArray.filter(codigo => codigo !== this.dataset.codigoSerie);
                    }

                    seriesSelecionados.value = seriesArray.join(',');
                });
            });

        });
    </script>
</x-app-layout>
