<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6 text-gray-300">Ordens de Serviço</h1>
        
        @if(session('error'))
            <div class="text-red-500 text-center mb-4">
                {{ session('error') }}
            </div>
        @endif
        
        <a href="{{ route('relatorio.clientes') }}"
            class="inline-block w-full max-w-xs py-3 px-6 text-center text-white font-semibold bg-blue-600 rounded-md shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-400 transition-all duration-300 ease-in-out"
            style="margin: 10px 0 10px 0;">
                {{ __('Voltar') }}
        </a>
        <form action="{{ route('relatorio.pdf') }}" method="POST" class="inline-block w-full max-w-xs"  target="_blank">
            @csrf
            <input type="hidden" name="ordensServico" value="{{ json_encode($ordensServico) }}">
            <input type="hidden" name="dadosSigecloud" value="{{ json_encode($dadosSigecloud) }}">
            <button type="submit"
                class="py-3 px-6 text-center text-white font-semibold bg-blue-600 rounded-md shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-400 transition-all duration-300 ease-in-out flex items-center justify-center space-x-2"
                style="margin: 10px 0 10px 0;">
                <!-- Ícone de impressora -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                </svg>
                <span>{{ __('Exportar') }}</span>
            </button>
        </form>
        <div class="bg-gray-100 p-4 mb-4 rounded-md">
            <h3 class="text-xl font-bold text-gray-800">Resumo de Tempos</h3>
            <ul class="list-disc pl-6">
                <li><span class="font-medium">Total de ordens:</span> {{ $totalOrdens }} ordens</li>
                <li><span class="font-medium">Tempo Nível 1 (N1):</span> {{ $totalTempos['N1'] }} Horas</li>
                <li><span class="font-medium">Tempo Nível 2 (N2):</span> {{ $totalTempos['N2'] }} Horas</li>
                <li><span class="font-medium">Tempo Nível 3 (N3):</span> {{ $totalTempos['N3'] }} Horas</li>
                <li><span class="font-medium">Ordens sem tempo:</span> {{ implode(', ', $totalTempos['Sem Tempo']) }}</li>
            </ul>
        </div>
      
        
        
        
        <div class="grid grid-cols-2 gap-6">
            <!-- Coluna 1: Ordens de Serviço -->
            <div>
                <h3 class="text-xl font-bold text-white">Pedidos (Milvus)</h3>
                @foreach($ordensServico as $ordem)
                    <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                        <div class="border-b border-gray-200 pb-2 mb-3">
                            <h5 class="text-lg font-semibold text-gray-800">O.S. ID: {{ $ordem['codigo'] }}</h5>
                        </div>
                        <div class="space-y-3"> 
                            @if($ordem['data_criacao'])
                                <div>
                                    <span class="font-medium text-gray-700">Data de Criação:</span> 
                                    <span>{{ \Carbon\Carbon::parse($ordem['data_criacao'])->format('d/m/Y H:i') }}</span>
                                </div>
                            @endif

                            @if($ordem['descricao'])
                                <div>
                                    <span class="font-medium text-gray-700">Descrição:</span> 
                                    <span>{{ $ordem['descricao'] }}</span>
                                </div>
                            @endif

                            @if($ordem['tecnico'])
                                <div>
                                    <span class="font-medium text-gray-700">Técnico:</span> 
                                    <span>{{ $ordem['tecnico'] }}</span>
                                </div>
                            @endif

                            @if($ordem['servico_realizado'])
                                <div>
                                    <span class="font-medium text-gray-700">Serviço Realizado:</span>
                                    <span>{{ $ordem['servico_realizado'] }}</span>
                                </div>
                            @endif
                
                            

                            @if($ordem['data_solucao'])
                                <div>
                                    <span class="font-medium text-gray-700">Data da Solução:</span> 
                                    <span>{{ \Carbon\Carbon::parse($ordem['data_solucao'])->format('d/m/Y H:i') }}</span>
                                </div>
                            @endif            
                
                            @if($ordem['status'])
                                <div>
                                    <span class="font-medium text-gray-700">Status:</span> 
                                    <span class="text-green-500 font-semibold">{{ $ordem['status'] }}</span>
                                </div>
                            @endif                                                                                                                       
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Coluna 2: Dados da API Sigecloud -->
            <div>
                <h3 class="text-xl font-bold text-white">Pedidos (Sigecloud)</h3>
                @foreach($dadosSigecloud as $pedido)
                    @if($pedido['StatusSistema'] === 'Pedido' || $pedido['StatusSistema'] === 'Pedido Nao Faturado')
                        <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                            <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                                <!-- Exibindo o Pedido ID -->
                                <h5 class="text-lg font-semibold text-gray-800">O.S. ID: {{ $pedido['Codigo'] }}</h5>
                                
                                <!-- Exibindo o Status do Pedido -->
                                <div><span class="font-medium text-gray-700">Data Abertura:</span> {{ $pedido['OrdemServico']['DataAbertura'] ?? 'Status não disponível' }}</div>                        
                                
                                <!-- Exibindo o Status do Pedido -->
                                <div><span class="font-medium text-gray-700">Data Abertura:</span> {{ $pedido['PlanoDeConta']?? 'Status não disponível' }}</div> 

                                <!-- Exibindo o Valor Final -->
                                <div><span class="font-medium text-gray-700">Valor Final:</span> R$ {{ number_format($pedido['ValorFinal'], 2, ',', '.') }}</div>
                                
                                <!-- Exibindo a Categoria -->
                                <div><span class="font-medium text-gray-700">Problema:</span> {{ $pedido['OrdemServico']['Problema'] }}</div>
                                                
                                <!-- Exibindo os Itens do Pedido -->
                                <div class="mt-4">
                                    <h6 class="text-md font-semibold text-gray-700">Itens do Pedido:</h6>
                                    @if(isset($pedido['Items']) && count($pedido['Items']) > 0)
                                        <ul class="list-disc pl-5">
                                            @foreach($pedido['Items'] as $item)
                                                <li class="mb-2">
                                                    <div><span class="font-medium text-gray-700">Código:</span> {{ $item['Codigo'] }}</div>
                                                    <div><span class="font-medium text-gray-700">Descrição:</span> {{ $item['Descricao'] }}</div>
                                                    <div><span class="font-medium text-gray-700">Quantidade:</span> {{ $item['Quantidade'] }}</div>
                                                    <div><span class="font-medium text-gray-700">Valor Unitário:</span> R$ {{ number_format($item['ValorUnitario'], 2, ',', '.') }}</div>
                                                    <div><span class="font-medium text-gray-700">Valor Total:</span> R$ {{ number_format($item['ValorTotal'], 2, ',', '.') }}</div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-gray-500">Nenhum item encontrado para este pedido.</p>
                                    @endif
                                </div>

                                <!-- Exibindo os Laudos dentro da Ordem de Serviço -->
                                <div class="mt-4">
                                    <h6 class="text-md font-semibold text-gray-700">Laudos do Pedido:</h6>
                                    @if(isset($pedido['OrdemServico']['Laudos']) && count($pedido['OrdemServico']['Laudos']) > 0)
                                        <ul class="list-disc pl-5">
                                            @foreach($pedido['OrdemServico']['Laudos'] as $laudo)
                                                <li class="mb-2">
                                                    <div><span class="font-medium text-gray-700">Técnico:</span> {{ $laudo['Tecnico'] }}</div>
                                                    <div><span class="font-medium text-gray-700">Data do Registro:</span> {{ \Carbon\Carbon::parse($laudo['DataRegistro'])->format('d/m/Y H:i') }}</div>
                                                    <div><span class="font-medium text-gray-700">Laudo Técnico Geral:</span> {{ $laudo['LaudoTecnicoGeral'] }}</div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-gray-500">Nenhum laudo encontrado para este pedido.</p>
                                    @endif
                                </div>
                            </div>                    
                        </div>
                    @endif
                @endforeach
            </div>
    
</x-app-layout>
