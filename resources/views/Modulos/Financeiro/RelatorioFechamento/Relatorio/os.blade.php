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
        <form action="{{ route('relatorio.pdf') }}" method="POST" class="inline-block w-full max-w-xs" target="_blank">
            @csrf
            <input type="hidden" name="ordensServico" id="ordensServico">
            <input type="hidden" name="ordensServico1" id="ordensServico1">
            <input type="hidden" name="dadosSigecloud" id="dadosSigecloud">
            <input type="hidden" name="totalTempos" id="totalTempos">
            <input type="hidden" name="totalTempos1" id="totalTempos1">

            <button type="submit"
                class="py-3 px-6 text-center text-white font-semibold bg-blue-600 rounded-md shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-400 transition-all duration-300 ease-in-out flex items-center justify-center space-x-2"
                style="margin: 10px 0 10px 0;" onclick="atualizarDadosAntesDeEnviar()">
                <!-- Ícone de impressora -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                </svg>
                <span>{{ __('Exportar') }}</span>
            </button>
        </form>        
        <div class="grid grid-cols-2 gap-6">
            <div class="bg-gray-100 p-4 mb-4 rounded-md">
                <h3 class="text-xl font-bold text-gray-800">Resumo de Tempos</h3>
                <ul class="list-disc pl-6" id="tempos">
                    <li><span class="font-medium">Total de ordens:</span> {{ $totalOrdens }} ordens</li>
                    <li>
                        <span class="font-medium">Tempo Nível 1 (N1):</span> 
                        <span class="tempo" data-nivel="N1">{{ $totalTempos['N1']/60 }}</span> Horas
                    </li>
                    <li>
                        <span class="font-medium">Tempo Nível 2 (N2):</span> 
                        <span class="tempo" data-nivel="N2">{{ $totalTempos['N2']/60 }}</span> Horas
                    </li>
                    <li>
                        <span class="font-medium">Tempo Nível 3 (N3):</span> 
                        <span class="tempo" data-nivel="N3">{{ $totalTempos['N3']/60 }}</span> Horas
                    </li>
                    <li>
                        <span class="font-medium">Dia do gerente:</span>
                        <span class="tempo" data-nivel="DG">{{  $totalTempos['Dia do Gerente'] }} </span> Dias
                    </li>
                    <li><span class="font-medium">Ordens sem tempo:</span> {{ implode(', ', $totalTempos['Sem Tempo']) }}</li>
                    <li><span class="font-medium">Ordens com tempo:</span></li>
                    <ul>
                        @foreach ($totalTempos['ordens'] as $ordem)
                            <li>
                                Número da Ordem: {{ $ordem['numero_ordem'] }} | 
                                Tempo Lido:
                                @if($ordem['classe'] !== 'G1' && $ordem['classe'] !== 'G2')
                                    <input 
                                        type="number" 
                                        class="tempo-input" 
                                        value="{{ number_format($ordem['tempo_lido'] / 60, 2) }}"
                                        data-ordem="{{ $ordem['numero_ordem'] }}"
                                        data-classe="{{ $ordem['classe'] }}" 
                                        min="0"
                                        step="0.01"
                                        style="width: 80px; text-align: center;" 
                                    />
                                @else
                                    <span>{{ number_format($ordem['tempo_lido'] / 60, 2) }} horas</span>
                                @endif                                
                                Horas | 
                                Classe: {{ $ordem['classe'] }}                                                    
                            </li>
                        @endforeach

                    </ul>
                </ul>
            </div>
            <div class="bg-gray-100 p-4 mb-4 rounded-md">
                <h3 class="text-xl font-bold text-gray-800">Valores a cobrar</h3>
                <ul class="list-disc pl-6" id="valores">    
                    <li>
                        <span class="font-medium">N1:</span> 
                        <span class="valor" data-nivel="N1">@php echo 'R$ ' .  floor(($totalTempos['N1'] / 60) * 100) . ',00'; @endphp</span>
                    </li>
                    <li>
                        <span class="font-medium">N2:</span> 
                        <span class="valor" data-nivel="N2">R$ {{ floor(($totalTempos['N2'] / 60) * 200) }},00</span>
                    </li>
                    <li>
                        <span class="font-medium">N3:</span> 
                        <span class="valor" data-nivel="N3">R$ {{ floor(($totalTempos['N3'] / 60) * 300) }},00</span>
                    </li>                   
                    <li><span class="font-medium">Dia do gerente:</span> @php echo 'R$ ' . floor(($totalTempos['Dia do Gerente']) * 500) . ',00' @endphp </li>
                    <li>
                        <span class="font-medium">Total Horas:</span>
                        <span id="totalHoras">
                            @php 
                                echo 'R$ ' . floor((($totalTempos['N1'] / 60) * 100) + (($totalTempos['N2'] / 60) * 200) + (($totalTempos['N3'] / 60) * 300)) . ',00'; 
                            @endphp
                        </span>
                    </li>
                    <li><span class="font-medium" >Total Pedidos:</span><span id="total">R$ 0,00</span></li>
                    <li><span class="font-medium" >Total Geral:</span><span id="totalGeral">R$ 0,00</span></li>
                </ul>
            </div>
        </div>
      
        
        
        
        <div class="grid grid-cols-2 gap-6">
            <!-- Coluna 1: Ordens de Serviço -->
            <div>
                <h3 class="text-xl font-bold text-white">Pedidos (Milvus)</h3>
                @foreach($ordensServico as $ordem)
                    @if($ordem['status'] === 'Finalizado')
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

                                @if($ordem['total_horas'])
                                    <div>
                                        <span class="font-medium text-red-700">TOTAL DE HORAS:</span> 
                                        <span>{{ $ordem['total_horas'] }}</span>
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
                    @endif
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
                                <div class="valor-final">
                                    <span class="font-medium text-gray-700">Valor Final:</span> 
                                    R$ {{ number_format($pedido['ValorFinal'], 2, ',', '.') }}
                                </div>
                                
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


<script>
     document.addEventListener('DOMContentLoaded', () => {
        let total = 0;

        // Selecionar todos os elementos que contêm os valores finais
        document.querySelectorAll('.valor-final').forEach(element => {
            const valorText = element.textContent.match(/R\$ ([\d.,]+)/);
            if (valorText) {
                const valor = parseFloat(valorText[1].replace('.', '').replace(',', '.'));
                total += valor;
            }
        });

        // Atualizar o total na página
        document.getElementById('total').textContent = `R$ ${total.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    });

    function atualizarTotalGeral() {
        // Seleciona todos os elementos com a classe 'valor'
        const valores = document.querySelectorAll('.valor');

        const n1 = parseFloat(document.querySelector('[data-nivel="N1"]').textContent.replace('R$', '').replace(',', '.')) || 0;
        const n2 = parseFloat(document.querySelector('[data-nivel="N2"]').textContent.replace('R$', '').replace(',', '.')) || 0;
        const n3 = parseFloat(document.querySelector('[data-nivel="N3"]').textContent.replace('R$', '').replace(',', '.')) || 0;
        const diaGerente = parseFloat(document.querySelector('[data-nivel="DG"]').textContent.replace('R$', '').replace(',', '.')) || 0;

        let total = 0;

        // Selecionar todos os elementos que contêm os valores finais
        document.querySelectorAll('.valor-final').forEach(element => {
            const valorText = element.textContent.match(/R\$ ([\d.,]+)/);
            if (valorText) {
                const valor = parseFloat(valorText[1].replace('.', '').replace(',', '.'));
                total += valor;
            }
        });

        const totalPedidos = total;

        // Soma os valores
        const totalGeral = (n1 + n2 + n3)*100 + totalPedidos;

        // Formata o total geral como moeda (R$ 0,00)
        const totalGeralFormatado = `R$ ${totalGeral.toFixed(2).replace('.', ',')}`;

        // Atualiza o elemento do Total Geral
        const totalGeralElement = document.getElementById('totalGeral');
        totalGeralElement.textContent = totalGeralFormatado;

        console.log('Total Pedidos:', totalPedidos);
        console.log('Total Geral Atualizado:', totalGeralFormatado);
    }

    atualizarTotalGeral();
   
    document.addEventListener("DOMContentLoaded", function() {
        // Captura os inputs de tempo
        const tempoInputs = document.querySelectorAll('.tempo-input');
        
        tempoInputs.forEach(input => {
            input.addEventListener('change', function() {
                const ordemNumero = this.getAttribute('data-ordem');
                const novoTempo = parseFloat(this.value);
                
                // Aqui você pode atualizar o valor no array $totalTempos com AJAX ou formulário
                // No exemplo abaixo, estou apenas exibindo uma mensagem de log
                console.log(`Ordem ${ordemNumero} novo tempo: ${novoTempo} minutos`);
                
                // Aqui seria o momento de calcular o novo total geral ou fazer a atualização da tela
                atualizarTotais();
            });
        });
    });

    // Função para atualizar os totais na interface (isso é apenas um exemplo)
    function atualizarTotais() {
        let totalHoras = 0;
        document.querySelectorAll('.tempo-input').forEach(input => {
            totalHoras += parseFloat(input.value);
        });
         // Chame a função sempre que houver alteração nos valores
        atualizarTotalGeral();


        // Exibindo o total de horas atualizado
        document.getElementById('totalHoras').innerText = `R$ ${Math.floor(totalHoras * 100)},00`;
    }

</script>

<script>
    function atualizarDadosAntesDeEnviar() {
        // Atualiza os campos com os dados mais recentes

        // Filtra ordens de serviço com status 'Finalizado'
        var ordensServico = {!! json_encode(collect($ordensServico)->filter(function($ordem) { return $ordem['status'] === 'Finalizado'; })) !!};
        document.getElementById('ordensServico').value = JSON.stringify(ordensServico);

        // Filtra dados Sigecloud com status 'Pedido' ou 'Pedido Nao Faturado'
        var dadosSigecloud = {!! json_encode(collect($dadosSigecloud)->filter(function ($pedido) { return $pedido['StatusSistema'] === 'Pedido' || $pedido['StatusSistema'] === 'Pedido Nao Faturado'; })) !!};
        document.getElementById('dadosSigecloud').value = JSON.stringify(dadosSigecloud);

        // Atualiza o total de tempos
        var totalTempos = {!! json_encode(collect($totalTempos)) !!};
        document.getElementById('totalTempos').value = JSON.stringify(totalTempos);
    
        // Obtém os tempos alterados da interface
        const ordensAtualizadas = [];
        document.querySelectorAll('.tempo-input').forEach(input => {
            const numeroOrdem = parseInt(input.dataset.ordem);
            const tempoLido = parseFloat(input.value) * 60; // Converte de horas para minutos
            const classe = input.dataset.classe;

            // Atualiza os tempos nas ordens
            ordensAtualizadas.push({
                numero_ordem: numeroOrdem,
                tempo_lido: tempoLido,
                classe: classe
            });
        });

        // Recalcula os totais por nível (N1, N2, N3, etc.)
        const totalTemposAtualizados = {
            N1: 0,
            N2: 0,
            N3: 0,
            "Dia do Gerente": 0,
            "Sem Tempo": [],
            ordens: ordensAtualizadas
        };

        ordensAtualizadas.forEach(ordem => {
            if (ordem.classe in totalTemposAtualizados) {
                totalTemposAtualizados[ordem.classe] += ordem.tempo_lido;
            }
        });

        // Atualiza os valores nos campos hidden
        document.getElementById('ordensServico1').value = JSON.stringify(ordensAtualizadas);

        // Atualiza o campo hidden com o totalTempos atualizado
        document.getElementById('totalTempos1').value = JSON.stringify(totalTemposAtualizados);

    }
</script>

<script>
    // Detecta a mudança no input de tempo
    document.querySelectorAll('.tempo-input').forEach(input => {
        input.addEventListener('input', function() {
            // Pega o número da ordem e o novo valor do tempo
            const numeroOrdem = this.dataset.ordem;
            const novoTempo = parseFloat(this.value); // Valor em minutos

            // Calcula a diferença
            const tempoAnterior = parseFloat(this.defaultValue); // O valor original antes de mudar
            const diferencaTempo = tempoAnterior - novoTempo;

            // Atualiza os tempos totais (N1, N2, N3)
            if (diferencaTempo !== 0) {
                // Identifica qual nível o tempo pertence (esse exemplo assume que você sabe a qual nível pertence a ordem)
                let nivel = this.dataset.classe; // Função que retorna o nível correspondente à ordem

                if (nivel) {
                    // Atualiza o valor do tempo para o nível correto
                    let tempoElemento = document.querySelector(`.tempo[data-nivel="${nivel}"]`);
                    if (tempoElemento) {
                        let tempoAtual = parseFloat(tempoElemento.textContent);
                        tempoElemento.textContent = (tempoAtual - diferencaTempo).toFixed(2); // Atualiza o valor do tempo no nível
                    }
                }
            }
        });
    });

    document.querySelectorAll('.tempo-input').forEach(input => {
    input.addEventListener('input', function() {
        const nivel = this.dataset.classe; // Obtém o nível (N1, N2, N3)
        const novoTempo = parseFloat(this.value) * 60; // Converte horas de volta para minutos
        const tempoAnterior = parseFloat(this.defaultValue) * 60; // Valor original em minutos
        const diferencaTempo = novoTempo - tempoAnterior;
         // Logs para inspeção
         console.log("Nível:", nivel);
        console.log("Novo Tempo (minutos):", novoTempo);
        console.log("Tempo Anterior (minutos):", tempoAnterior);
        console.log("Diferença de Tempo (minutos):", diferencaTempo);

        // Atualizar o valor da classe correspondente
        if (nivel) {
            let valorElemento = document.querySelector(`.valor[data-nivel="${nivel}"]`);
            if (valorElemento) {
                let valorAtual = parseFloat(valorElemento.textContent.replace('R$', '').replace(',', ''));
                let fator = 0;
                console.log("Valor atual:", valorAtual);
                if (nivel === 'N1') fator = 100;
                if (nivel === 'N2') fator = 200;
                if (nivel === 'N3') fator = 300;

                const novoValor = valorAtual/100 + (diferencaTempo / 60) * fator;
                valorElemento.textContent = `R$ ${Math.floor(novoValor)},00`;
            }
        }

        // Atualizar o valor padrão do input
        this.defaultValue = novoTempo / 60;
    });
});

</script>
