<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6 text-gray-300">Lista de Clientes</h1>

        @if(session('error'))
            <div class="text-red-500 text-center mb-4">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="text-green-500 text-center mb-4">
                {{ session('success') }}
            </div>
        @endif

            
        <!-- Botão para Limpar o Cache -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <!-- Botão Limpar Cache -->
                <form action="{{ route('limpar.cache') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-600 text-white p-2 rounded-md hover:bg-red-700">
                        Limpar Cache
                    </button>
                </form>                        
                <button id="tooltip-button" class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">
                    ?
                </button>
            </div>
            <!-- Tooltip com texto explicativo -->
            <div id="tooltip-text" class="hidden mt-2 text-gray-500 text-sm">
                <p><strong>Atenção:</strong> Caso tenha feito alguma alteração nos tickets no Milvus ou em outros dados importantes, é recomendável limpar o cache do sistema para garantir que as atualizações sejam refletidas corretamente no sistema.</p>
            </div>
        </div>

        <div class="mt-6 mb-6 text-center">
            <a href="{{ route('financeiro.index') }}" class="inline-block px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600">
                Voltar para o Financeiro
            </a>
        </div>

        <!-- Formulário de Busca e Filtros -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <input 
                    type="text" 
                    id="search-input" 
                    placeholder="Buscar por Nome, Razão Social ou CNPJ" 
                    class="w-full sm:w-1/2 p-2 rounded-md border border-gray-600 bg-gray-800 text-gray-300 placeholder-gray-500 focus:outline-none"
                >
            </div>
        </div>

        <!-- Tabela de Clientes -->
        <div id="clientes-container" class="overflow-x-auto bg-gray-800 rounded-lg shadow-md">
            <table class="min-w-full bg-gray-700">
                <thead>
                    <tr class="text-left">
                        <th class="px-4 py-2 text-gray-300">ID</th>
                        <th class="px-4 py-2 text-gray-300">Nome Fantasia</th>
                        <th class="px-4 py-2 text-gray-300">Razão Social</th>
                        <th class="px-4 py-2 text-gray-300">CNPJ/CPF</th>
                        <th class="px-4 py-2 text-gray-300">Ações</th>
                    </tr>
                </thead>
                <tbody id="clientes-table-body">
                    @foreach($clientes as $cliente)
                        <tr class="hover:bg-gray-600 cliente-row" data-nome="{{ $cliente['nome_fantasia'] }}" data-razao="{{ $cliente['razao_social'] }}" data-cnpj="{{ $cliente['cnpj_cpf'] }}" data-equipes="{{ implode(',', $cliente['equipes']) }}">
                            <td class="px-4 py-2 text-gray-300">{{ $cliente['id'] }}</td>
                            <td class="px-4 py-2 text-gray-300">{{ $cliente['nome_fantasia'] }}</td>
                            <td class="px-4 py-2 text-gray-300">{{ $cliente['razao_social'] }}</td>
                            <td class="px-4 py-2 text-gray-300">{{ $cliente['cnpj_cpf'] }}</td>                          
                            <td class="px-4 py-2 text-gray-300">
                                <!-- Botão para abrir o modal -->
                                <a  href="#" 
                                    onclick="openModal({{ $cliente['id'] }}, '{{ $cliente['cnpj_cpf'] }}')"
                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 flex items-center space-x-2">
                                        <!-- Ícone de ticket -->
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                                        </svg>
                                        <span>Ver Tickets</span>
                                </a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Nenhum cliente encontrado -->
        <div id="no-results" class="text-center text-gray-300 mt-6 hidden">
            Nenhum cliente encontrado.
        </div>
    </div>

    <!-- Modal de Seleção de Data -->
    <div id="modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-2xl text-gray-300 mb-4">Selecionar Período</h2>
            
            <!-- Data Inicial e Final -->
            <div class="mb-4">
                <label for="data-inicial" class="text-gray-300">Data Inicial</label>
                <input type="date" id="data-inicial" class="w-full p-2 bg-gray-700 text-gray-300 border border-gray-600 rounded-md focus:outline-none">
            </div>
            
            <div class="mb-4">
                <label for="data-final" class="text-gray-300">Data Final</label>
                <input type="date" id="data-final" class="w-full p-2 bg-gray-700 text-gray-300 border border-gray-600 rounded-md focus:outline-none">
            </div>
            
            <div class="flex justify-between">
                <button onclick="closeModal()" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Cancelar</button>
                <button onclick="applyDateRange()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Aplicar</button>
            </div>
        </div>
    </div>

    <script>        
        // Function to close the modal
        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        // Função para abrir o modal e armazenar o CNPJ
        function openModal(clienteId, cnpj) {
            document.getElementById('modal').classList.remove('hidden');
            window.clienteId = clienteId;  // Armazena o clienteId para uso posterior
            window.cnpj = cnpj;  // Armazena o CNPJ para uso posterior
        }

        // Função para aplicar o intervalo de datas e redirecionar
        function applyDateRange() {
            const dataInicial = document.getElementById('data-inicial').value;
            const dataFinal = document.getElementById('data-final').value;

            if (dataInicial && dataFinal) {
                 // Construindo a URL corretamente com todos os parâmetros
                const baseUrl = `{{ route('ordens-servico', ['cliente_id' => '__clienteId__', 'cnpj' => '__cnpj__']) }}`
                    .replace('__clienteId__', window.clienteId)
                    .replace('__cnpj__', window.cnpj);

                // Acrescentando os parâmetros de data na URL
                const urlWithDates = `${baseUrl}?data_inicial=${dataInicial}&data_final=${dataFinal}`;

        // Redirecionando para a URL
        window.location.href = urlWithDates;
            } else {
                alert('Por favor, selecione as datas inicial e final.');
            }
        }

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('search-input');
            const clientesTableBody = document.getElementById('clientes-table-body');
            const noResultsDiv = document.getElementById('no-results');
            const clienteRows = document.querySelectorAll('.cliente-row');
    
            // Função para filtrar os clientes
            function filterClientes() {
                const searchQuery = searchInput.value.toLowerCase();
    
                let visibleCount = 0;
                clienteRows.forEach(row => {
                    const nome = row.dataset.nome.toLowerCase();
                    const razao = row.dataset.razao.toLowerCase();
                    const cnpj = row.dataset.cnpj.toLowerCase();
    
                    const matchesSearch = !searchQuery || nome.includes(searchQuery) || razao.includes(searchQuery) || cnpj.includes(searchQuery);
    
                    if (matchesSearch) {
                        row.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        row.classList.add('hidden');
                    }
                });
    
                noResultsDiv.classList.toggle('hidden', visibleCount > 0);
            }
    
            // Adicionar evento de filtro
            searchInput.addEventListener('input', filterClientes);
        });
    </script>
    
    <script>
        // Função para alternar a visibilidade do texto
        document.getElementById('tooltip-button').addEventListener('click', function() {
            const tooltipText = document.getElementById('tooltip-text');
            tooltipText.classList.toggle('hidden'); // Mostra/oculta o texto
        });
    </script>
</x-app-layout>
