<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Ordens e Pedidos</title>
    <style>
       @page {
            margin: 0; /* Sem margem na primeira página */
        }
        .container:nth-of-type(n+2) {
            margin-top: 3em; /* Aplica margem somente a partir da segunda página */
        }


        body {
            
            background: url({{ public_path('img/timbrado/timbradocolor2.jpg') }}) no-repeat top center;
            background-size: cover; /* Garante que o fundo fique proporcional */
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            position: relative;
            z-index: 2;
            padding: 50px;
            margin: 0px auto; /* Margens no topo e rodapé para o timbrado */
            font-size: 1rem;
        }

        .ordem, .pedido {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        h1 {
            font-size: 2rem;
            text-align: center;
            margin-bottom: 40px;
        }

        .titulo {
            font-weight: bold;
        }

         /* Estilo para o cabeçalho */
         .header-info {
            font-size: 1rem;
            margin-bottom: 30px;
        }
        
        .header-info div {
            margin: 5px 0;
        }

        .dados-chamado {
            border: 2px solid #000;
            padding: 20px;
            margin-bottom: 30px;
            background-color: #f9f9f9;
        }

        .dados-chamado .titulo {
            font-weight: bold;
        }
        /* Definir a estrutura de duas colunas com classes personalizadas */
        /* Estilo geral para o container do relatório */
        .relatorio-container {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        /* Estilo para as colunas dentro do relatório */
        .relatorio-coluna {
            margin-bottom: 30px;
        }

        /* Título do relatório */
        .relatorio-titulo {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }

        /* Lista geral */
        .relatorio-lista {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        /* Itens da lista */
        .relatorio-lista-item {
            font-size: 16px;
            margin: 8px 0;
            padding: 8px 10px;
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
        }

        /* Destaque para valores médios */
        .relatorio-font-medium {
            font-weight: bold;
            color: #333;
        }

        /* Estilo para a tabela */
        .relatorio-tabela {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .relatorio-tabela th, .relatorio-tabela td {
            padding: 12px 15px;
            text-align: left;
            font-size: 16px;
            border-bottom: 1px solid #ddd;
        }

        /* Estilo para as células do cabeçalho */
        .relatorio-tabela th {
            background-color: #f4f4f4;
            color: #333;
            text-transform: uppercase;
            font-weight: bold;
        }

        /* Estilo para o conteúdo das células */
        .relatorio-tabela td {
            color: #555;
        }

        /* Alinhar os valores à direita para números */
        .relatorio-tabela td[style="text-align: right;"] {
            text-align: right;
        }

        /* Estilo para o Total Geral */
        .relatorio-tabela tr:last-child td {
            font-weight: bold;
            font-size: 18px;
            background-color: #f4f4f4;
        }

        .relatorio-tabela tr:last-child td:first-child {
            color: #333;
        }

        /* Estilo para os itens de descrição */
        .relatorio-tabela .relatorio-font-medium {
            font-weight: bold;
            color: #333;
        }

        /* Adicionar borda ao redor da tabela */
        .relatorio-tabela {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            margin-top: 20px;
        }

        /* Estilo do item de descrição dos itens */
        .relatorio-tabela .relatorio-lista-item {
            font-size: 16px;
            color: #555;
        }

        /* Melhorar espaçamento e legibilidade */
        .relatorio-tabela td {
            padding: 15px 20px;
        }

        /* Adicionar sombra ao redor do container */
        .relatorio-container {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        /* Personalizar os links ou botões caso tenha */
        .relatorio-container a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        .relatorio-container a:hover {
            text-decoration: underline;
        }

        /* Adiciona a margem no topo do container a partir da segunda página */
        .page-break {
            margin-top: 3em; /* Margem de 3em a partir da segunda página */
        }

        /* Forçar a quebra de página manualmente */
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-info">
            <div><strong>LOTUS SQUAD TI, LOTUS SQUAD TI LTDA, CNPJ: 37228670000170</strong></div>
            <div>Rua Sete de Setembro, 1531 LOJA - 02 / Centro / Campo Largo - PR / 83601170</div>
            <div>consultoria@lotussquad.com / 4130731174</div>
        </div>

        <!-- Bloco com as informações do chamado -->
        <!-- Dados do Chamado (Primeiro Pedido) -->
        @foreach($dadosSigecloud as $pedido)
            <div class="dados-chamado" style="border: 1px solid #ddd; padding: 20px; margin: 10px 0; border-radius: 8px; background-color: #f9f9f9;">
                <!-- Cliente e CNPJ -->
                <div style="margin-bottom: 10px;">
                    <div style="display: inline-block; width: 48%;"><span class="titulo" style="font-weight: bold;">Cliente:</span> {{ $pedido['Cliente'] }}</div>
                    <div style="display: inline-block; width: 48%;"><span class="titulo" style="font-weight: bold;">CNPJ:</span> {{ $pedido['ClienteCNPJ'] }}</div>
                </div>
            
                <!-- Endereço, Bairro, Cidade e CEP -->
                <div style="margin-bottom: 10px;">
                    <div style="display: inline-block; width: 48%;"><span class="titulo" style="font-weight: bold;">Endereço:</span> {{ $pedido['Logradouro'] }} {{ $pedido['LogradouroNumero'] }} {{ $pedido['LogradouroComplemento'] }}</div>
                    <div style="display: inline-block; width: 48%;"><span class="titulo" style="font-weight: bold;">Bairro:</span> {{ $pedido['Bairro'] }} </div>
                </div>
            
                <div style="margin-bottom: 10px;">
                    <div style="display: inline-block; width: 48%;"><span class="titulo" style="font-weight: bold;">Cidade:</span> {{ $pedido['Municipio'] }}</div>
                    <div style="display: inline-block; width: 48%;"><span class="titulo" style="font-weight: bold;">CEP:</span> {{ $pedido['CEP'] }}</div>
                </div>               
            </div>              
            @break
        @endforeach

        <div class="relatorio-container">
            <!-- Coluna 1 -->
            <div class="relatorio-coluna">
                <!-- Resumo -->
                <h3 class="relatorio-titulo">Resumo</h3>
                <ul class="relatorio-lista">
                    <li class="relatorio-lista-item">Total de ordens: {{ count($ordensServico) }} ordens</li>
                    @if($totalTempos['N1'] != 0)
                        <li class="relatorio-lista-item">Tempo Nível 1 (N1): @php echo number_format(($totalTempos1['N1']/60), 2, ',', '.') @endphp Horas</li>
                    @endif
                    @if($totalTempos['N2'] != 0)
                        <li class="relatorio-lista-item">Tempo Nível 2 (N2): @php echo number_format(($totalTempos1['N2']/60), 2, ',', '.') @endphp Horas</li>
                    @endif
                    @if($totalTempos['N3'] != 0)
                        <li class="relatorio-lista-item">Tempo Nível 3 (N3): @php echo number_format(($totalTempos1['N3']/60), 2, ',', '.')  @endphp Horas</li>
                    @endif
                </ul>
        
                <!-- Valores a Cobrar e Total de Pedidos juntos -->
                <h3 class="relatorio-titulo">Valores</h3>
                <table class="relatorio-tabela">
                    <thead>
                        <tr>
                            <th style="text-align: left; padding-left: 10px;">Descrição</th>
                            <th style="text-align: right; padding-right: 10px;">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Valores a Cobrar -->
                        @if($totalTempos1['N1'] != 0)
                            <tr>
                                <td><strong>N1</strong></td>
                                <td style="text-align: right;">R$ {{ number_format(($totalTempos1['N1']/60) * 100, 2, ',', '.') }}</td>
                            </tr>
                        @endif
                        @if($totalTempos1['N2'] != 0)
                            <tr>
                                <td><strong>N2</strong></td>
                                <td style="text-align: right;">R$ {{ number_format(($totalTempos1['N2']/60) * 200, 2, ',', '.') }}</td>
                            </tr>
                        @endif
                        @if($totalTempos1['N3'] != 0)
                            <tr>
                                <td><strong>N3</strong></td>
                                <td style="text-align: right;">R$ {{ number_format(($totalTempos1['N3']/60) * 300, 2, ',', '.') }}</td>
                            </tr>
                        @endif
                        @if($totalTempos['Dia do Gerente'] != 0)
                        <tr>
                            <td><strong>Dia do Gerente</strong></td>
                            <td style="text-align: right;">R$ {{ number_format(($totalTempos['Dia do Gerente']) * 500, 2, ',', '.') }}</td>
                        </tr>
                    @endif
                        <!-- Total de Pedidos -->
                        @php
                            $totalPedidos = 0;
                            $totalItensDescricao = [];
                        @endphp
                        @foreach($dadosSigecloud as $pedido)
                            @foreach($pedido['Items'] as $item)
                                @php
                                    $totalPedidos += $item['ValorTotal'];
                                    $totalItensDescricao[] = $item['Descricao'];
                                @endphp
                                <tr>
                                    <td>{{ $item['Descricao'] }}</td>
                                    <td style="text-align: right;">R$ {{ number_format($item['ValorTotal'], 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                        
                        <!-- Total Geral -->
                        <tr>
                            <td><strong>Total Geral:</strong></td>
                            <td style="text-align: right; font-weight: bold;">
                                R$ {{ number_format((($totalTempos1['N1']/60)*100 + ($totalTempos1['N2']/60)*200 + ($totalTempos1['N3']/60)*300) + $totalPedidos + $totalTempos['Dia do Gerente'] * 500 , 2, ',', '.') }}
                            </td>
                        </tr>                            
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="page-break"></div>    

        <h1>Relatório de Tickets e Produtos</h1>
        
        <h2>Tickets</h>
        @foreach($ordensServico as $ordem)
            <div class="ordem">
                <div><span class="titulo">Data da Solução:</span> {{ $ordem['data_solucao'] }}</div>
                <div><span class="titulo">Descrição:</span> {{ $ordem['descricao'] }}</div>
                <div><span class="titulo">Serviço Realizado:</span> {{ $ordem['servico_realizado'] }}</div>
                <div><span class="titulo">Técnico:</span> {{ $ordem['tecnico'] }}</div>
            </div>
        @endforeach
        
        <div class="page-break"></div>        

        <h2>Produtos</h2>
        @foreach($dadosSigecloud as $pedido)
            <div class="pedido">
                <div>
                    <strong>Pedido ID:</strong> {{ $pedido['ID'] }}
                </div>
                <div>
                    <strong>Cliente:</strong> {{ $pedido['Cliente'] }}
                </div>
                <div>
                    <strong>Status:</strong> {{ $pedido['StatusSistema'] }}
                </div>
                <div>
                    <strong>Valor Final:</strong> R$ {{ number_format($pedido['ValorFinal'], 2, ',', '.') }}
                </div>

                <!-- Exibindo os Itens do Pedido -->
                <div style="margin-top: 10px;">
                    <strong>Itens do Pedido:</strong>
                    @if(isset($pedido['Items']) && count($pedido['Items']) > 0)
                        <table style="width: 100%; border-collapse: collapse; margin-top: 5px;">
                            <thead>
                                <tr>
                                    <th style="border: 1px solid #000; padding: 5px; text-align: left;">Código</th>
                                    <th style="border: 1px solid #000; padding: 5px; text-align: left;">Descrição</th>
                                    <th style="border: 1px solid #000; padding: 5px; text-align: center;">Quantidade</th>
                                    <th style="border: 1px solid #000; padding: 5px; text-align: right;">Valor Unitário</th>
                                    <th style="border: 1px solid #000; padding: 5px; text-align: right;">Valor Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pedido['Items'] as $item)
                                    <tr>
                                        <td style="border: 1px solid #000; padding: 5px;">{{ $item['Codigo'] }}</td>
                                        <td style="border: 1px solid #000; padding: 5px;">{{ $item['Descricao'] }}</td>
                                        <td style="border: 1px solid #000; padding: 5px; text-align: center;">{{ $item['Quantidade'] }}</td>
                                        <td style="border: 1px solid #000; padding: 5px; text-align: right;">R$ {{ number_format($item['ValorUnitario'], 2, ',', '.') }}</td>
                                        <td style="border: 1px solid #000; padding: 5px; text-align: right;">R$ {{ number_format($item['ValorTotal'], 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p style="margin-top: 5px; font-style: italic;">Nenhum item encontrado para este pedido.</p>
                    @endif
                </div>
            </div>
        @endforeach

    </div>
</body>
</html>
