<x-app-layout>
    <div class="max-w-2xl mx-auto mt-8 bg-gray-800 p-6 rounded-lg shadow-md">
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="text-2xl font-bold text-white mb-6">Adicionar Patrimônios ao Grupo</h1>

        <form action="{{ route('grupo_patrimonios.salvarPatrimonio', $grupoPatrimonioId) }}" method="POST" class="space-y-6">
            @csrf

            <!-- Campo oculto para armazenar os códigos de série selecionados -->
            <input type="hidden" id="seriesSelecionados" name="seriesSelecionados" value="">

            <!-- Barra de Busca -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-300">Buscar Patrimônio:</label>
                <input type="text" id="search" name="search" class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-md shadow-sm" placeholder="Buscar por código ou nome..." autocomplete="off">
                <div id="search-results" class="mt-2 space-y-2 hidden"></div>
            </div>

            <!-- Lista de Patrimônios Disponíveis para Seleção -->
            <div class="mb-4">
                <h2 class="text-xl text-white">Selecione os Patrimônios</h2>
                <div class="space-y-2" id="patrimonio-list">
                    @foreach ($patrimonio as $patr)
                    
                        @php
                            // Verifica se 'series' não está vazio e decodifica
                            $series = !empty($patr->series) ? json_decode($patr->series) : [];
                        @endphp
                        <div class="patrimonio-item">
                            @foreach ($series as $serie)
                                @if ($serie->estado === 'disponivel') <!-- Exibe apenas séries com estado 'disponivel' -->
                                    <div class="flex items-center patrimonio-data" data-nome="{{ $patr->nome_completo }}" data-codigo="{{ $serie->codigo }}">
                                        <input type="checkbox" id="patrimonio_{{ $patr->id }}_serie_{{ $serie->codigo }}" name="patrimonios[]" value="{{ $patr->id }}" class="mr-2 patrimonio-checkbox" data-codigo-serie="{{ $serie->codigo }}">
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

            <div class="pt-4">
                <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700">
                    Criar Grupo e Anexar
                </button>
            </div>
        </form>

        <a href="{{ route('grupo_patrimonios.index') }}" class="mt-6 inline-block w-full bg-blue-600 py-3 px-6 text-white text-center rounded-md hover:bg-blue-700">
            Voltar
        </a>
    </div>

    <!-- Script para filtragem e marcar ao pressionar Enter -->
    <script>
        document.getElementById('search').addEventListener('input', function () {
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
    
        document.getElementById('search').addEventListener('keydown', function(event) {
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
        const checkboxes = document.querySelectorAll('.patrimonio-checkbox');
        const seriesSelecionados = document.getElementById('seriesSelecionados');
    
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                let seriesArray = seriesSelecionados.value ? seriesSelecionados.value.split(',') : [];
    
                if (this.checked) {
                    // Adiciona o código de série ao array
                    if (!seriesArray.includes(this.dataset.codigoSerie)) {
                        seriesArray.push(this.dataset.codigoSerie);
                    }
                } else {
                    // Remove o código de série do array
                    seriesArray = seriesArray.filter(codigo => codigo !== this.dataset.codigoSerie);
                }
    
                // Atualiza o campo oculto
                seriesSelecionados.value = seriesArray.join(',');
            });
        });
    </script>
    
</x-app-layout>
