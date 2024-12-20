<x-app-layout>
    <div class="max-w-2xl mx-auto mt-8 bg-gray-800 p-6 rounded-lg shadow-md">
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="text-2xl font-bold text-white mb-6">Retirar Patrimônios - Consulta</h1>

        <form action="{{ route('retiradas.buscar') }}" method="GET" class="space-y-6">
            @csrf

            <!-- Campo de Busca para ID da Retirada -->
            <div class="mb-4">
                <label for="id_retirada" class="block text-white">ID da Retirada:</label>
                <input type="text" id="id_retirada" name="id_retirada" class="w-full p-2 mt-2 rounded bg-gray-700 text-white"
                       placeholder="Digite o ID da retirada" required>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">
                    Buscar Retirada
                </button>
            </div>
        </form>

        @isset($retirada)
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-white">Detalhes da Retirada</h2>
                <div class="bg-gray-700 p-4 rounded-lg mt-4">
                    <p class="text-white"><strong>ID da Retirada:</strong> {{ $retirada->id }}</p>
                    <p class="text-white"><strong>Responsável pela Retirada:</strong> {{ $retirada->responsavel->name }}</p>
                    <p class="text-white"><strong>Técnico Responsável:</strong> {{ $retirada->tecnicoResponsavel->name }}</p>
                    <p class="text-white"><strong>Anotações:</strong> {{ $retirada->anotacoes ?? 'Nenhuma anotação' }}</p>                 


                    <h3 class="text-xl text-white mt-4">Itens Retirados</h3>
                    @php
                        // Verifica se existem grupos associados à retirada e os patrimônios retirados
                        $exibirGrupos = is_array(json_decode($retirada->grupos, true)) && count(json_decode($retirada->grupos, true)) > 0;
                        $patrimonios = str_replace('"', '', $retirada->patrimonios);
                        $patrimoniosArray = explode(',', $patrimonios);
                        $exibirPatrimonios = is_array($patrimoniosArray) && count($patrimoniosArray) > 0;
                    @endphp

                    @if ($exibirGrupos)
                        <div class="grupos mt-4">
                            <h3 class="text-lg font-semibold text-white mb-3">Grupos de Patrimônios</h3>
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-white uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">Selecionar</th>
                                            <th scope="col" class="px-6 py-3">Nome do Item</th>
                                            <th scope="col" class="px-6 py-3">Código de Série</th>
                                            <th scope="col" class="px-6 py-3">Lost</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (json_decode($retirada->grupos, true) as $grupoId)
                                            @php
                                                $grupo = $grupoAll->firstWhere('id', $grupoId);
                                            @endphp
                                            @if ($grupo)
                                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                                    <td colspan="4" class="text-center px-6 py-4 text-white font-semibold">Código: {{ $grupo->id ?? 'ID não disponível' }} - {{ $grupo->nome ?? 'Nome não disponível' }}</td>
                                                </tr>
                                                @php
                                                    $itensGrupo = $itemsgrupoAll->where('id_grupo_patrimonio', $grupo->id);
                                                @endphp
                                                @foreach ($itensGrupo as $item)
                                                    <tr class="border-b">
                                                        <td class="px-6 py-4">
                                                            <input type="checkbox" class="rounded grupo-checkbox" checked>
                                                        </td>
                                                        <td class="px-6 py-4">{{ $item->nome ?? 'Nome não disponível' }}</td>
                                                        <td class="px-6 py-4">{{ $item->serie ?? 'Série não disponível' }}</td>
                                                        <td class="px-6 py-4 lost-column hidden">
                                                            <input type="text" name="lost_grupos[{{ $item->serie }}]" value="" placeholder="Descreva o Lost" class="form-input text-gray-500 bg-gray-100 rounded w-full text-[0.7rem]"> 
                                                        </td>> 
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    @if ($exibirPatrimonios)
                        <div class="patrimonios mt-4">
                            <h3 class="text-lg font-semibold text-white mb-3">Patrimônios Retirados</h3>
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">Selecionar</th>
                                            <th scope="col" class="px-6 py-3">Nome do Patrimônio</th>
                                            <th scope="col" class="px-6 py-3">Código</th>
                                            <th scope="col" class="px-6 py-3">Lost</th>  
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($patrimoniosArray as $codigoSerie)
                                            @php
                                                $codigoSerie = str_replace(['[', ']', ' '], '', $codigoSerie);
                                                $codigoPatrimonio = substr($codigoSerie, 0, -3);
                                                $patrimonio = $patrimonioAll->firstWhere('codigo', $codigoPatrimonio);
                                            @endphp
                                            @if ($patrimonio)
                                                <tr class="border-b">
                                                    <td class="px-6 py-4">
                                                        <input type="checkbox" class="rounded patrimonio-checkbox" checked>
                                                    </td>
                                                    <td class="px-6 py-4">{{ $patrimonio->nome_completo ?? 'Nome não disponível' }}</td>
                                                    <td class="px-6 py-4">{{ $codigoSerie ?? 'Código não disponível' }}</td>
                                                    <td class="px-6 py-4 lost-column hidden">
                                                        <input type="text" name="lost_patrimonios[{{ $codigoSerie }}]" value="" placeholder="Descreva o Lost" class="form-input text-gray-500 bg-gray-100 rounded w-full text-[0.7rem]">     
                                                    </td> 
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif


                    <form action="{{ route('retiradas.confirmar.volta', $retirada->id) }}" method="POST" class="mt-6" id="confirmarDevolucaoForm">
                        @csrf
                        <div class="pt-4">
                            <button type="submit" class="w-full py-2 px-4 bg-green-600 text-white font-semibold rounded-md hover:bg-green-700">
                                Confirmar Devolução
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endisset

        <a href="{{ route('retiradas.index') }}" class="mt-6 inline-block w-full bg-blue-600 py-3 px-6 text-white text-center rounded-md hover:bg-blue-700">
            Voltar
        </a>
    </div>

    <script>
        document.querySelectorAll('.patrimonio-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const row = this.closest('tr');  // Pega a linha do item
                const lostColumn = row.querySelector('.lost-column');  // Seleciona a coluna Lost
                
                if (!this.checked) {
                    // Se o checkbox for desmarcado, mostra a coluna Lost
                    lostColumn.classList.remove('hidden');
                } else {
                    // Se o checkbox for marcado, esconde a coluna Lost
                    lostColumn.classList.add('hidden');
                }
            });
        });

        document.querySelectorAll('.grupo-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const row = this.closest('tr');  // Pega a linha do item
                const lostColumn = row.querySelector('.lost-column');  // Seleciona a coluna Lost
                
                if (!this.checked) {
                    // Se o checkbox for desmarcado, mostra a coluna Lost
                    lostColumn.classList.remove('hidden');
                } else {
                    // Se o checkbox for marcado, esconde a coluna Lost
                    lostColumn.classList.add('hidden');
                }
            });
        });

        document.getElementById('confirmarDevolucaoForm').addEventListener('submit', function(event) {
            // Prevenir o envio do formulário até adicionar os campos de lost
            event.preventDefault();

            // Captura os valores dos campos 'lost' dos grupos
            const lostGrupos = {};
            document.querySelectorAll('[name^="lost_grupos"]').forEach(function(input) {
                const grupoId = input.name.replace('lost_grupos[', '').replace(']', ''); // Extraindo o ID do grupo
                if (input.value.trim()) {  // Verificar se o campo tem algum valor preenchido
                    lostGrupos[grupoId] = input.value.trim(); // Armazena o valor no objeto lostGrupos
                }
            });

            // Captura os valores dos campos 'lost' dos patrimônios
            const lostPatrimonios = {};
            document.querySelectorAll('[name^="lost_patrimonios"]').forEach(function(input) {
                const patrimonioId = input.name.replace('lost_patrimonios[', '').replace(']', ''); // Extraindo o ID do patrimônio
                if (input.value.trim()) {  // Verificar se o campo tem algum valor preenchido
                    lostPatrimonios[patrimonioId] = input.value.trim(); // Armazena o valor no objeto lostPatrimonios
                }
            });

            // Adiciona os valores de lost_grupos e lost_patrimonios como inputs ocultos no formulário
            Object.keys(lostGrupos).forEach(function(grupoId) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `lost_grupos[${grupoId}]`;
                input.value = lostGrupos[grupoId];
                document.getElementById('confirmarDevolucaoForm').appendChild(input);
            });

            Object.keys(lostPatrimonios).forEach(function(patrimonioId) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `lost_patrimonios[${patrimonioId}]`;
                input.value = lostPatrimonios[patrimonioId];
                document.getElementById('confirmarDevolucaoForm').appendChild(input);
            });

            // Agora envia o formulário
            this.submit();
        });


    </script>
</x-app-layout>
