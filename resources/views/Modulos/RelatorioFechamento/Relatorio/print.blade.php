<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Ordens e Pedidos</title>
    <style>
        @page {
            margin: 0; /* Margem da página */
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
        }

        .ordem, .pedido {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
        }

        h1 {
            font-size: 2rem;
            text-align: center;
            margin-bottom: 40px;
        }

        .titulo {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }

        .page-content:first-child {
            margin-top: 50px;
        }

        .page-content:nth-child(n+2) {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <h1>Relatório de Ordens e Pedidos</h1>
        
        <h2>Ordens de Serviço</h2>
        @foreach($ordensServico as $ordem)
            <div class="ordem">
                <div><span class="titulo">Data da Solução:</span> {{ $ordem['data_solucao'] }}</div>
                <div><span class="titulo">Descrição:</span> {{ $ordem['descricao'] }}</div>
                <div><span class="titulo">Serviço Realizado:</span> {{ $ordem['servico_realizado'] }}</div>
                <div><span class="titulo">Técnico:</span> {{ $ordem['tecnico'] }}</div>
            </div>
        @endforeach
        
        <h2>Pedidos (Sigecloud)</h2>
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
