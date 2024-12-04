<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Ordens de Serviço</title>
    <style>
        @page {
        margin: 0; /* Remove as margens do DomPDF */
        }
        body {
            margin: 0; /* Remove as margens no CSS */
            padding: 0;
            width: 100%;
            height: 100%;
            background: url({{public_path('img/timbrado/timbradocolor.jpg')}}) no-repeat center center;
            background-size: cover;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            position: relative;
            z-index: 2;
            padding: 50px;
        }

        .ordem {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            background: rgba(255, 255, 255, 0.8);
        }

        h1 {
            font-size: 2rem;
            text-align: center;
            margin: 60px 0;
        }

        .titulo {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }

        .margem{
            margin-bottom: 120px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Relatório de Ordens de Serviço</h1>
        @foreach($ordensServico as $index => $ordem)
            <div class="ordem">
                <h5>Ordem de Serviço - Código: {{ $loop->iteration }}</h5>
                <div>
                    <span class="titulo">Data da Solução:</span> 
                    <span>{{ $ordem['data_solucao'] }}</span>
                </div>
                <div>
                    <span class="titulo">Descrição:</span> 
                    <span>{{ $ordem['descricao'] }}</span>
                </div>
                <div>
                    <span class="titulo">Serviço Realizado:</span> 
                    <span>{{ $ordem['servico_realizado'] }}</span>
                </div>
                <div>
                    <span class="titulo">Técnico:</span> 
                    <span>{{ $ordem['tecnico'] }}</span>
                </div>
            </div>
        
            {{-- Adiciona a quebra de página a cada 4 itens --}}
            @if( $loop->iteration  % 4 == 0 && !$loop->last)
                <div class="page-break"></div>
                <div class="margem"></div>
            @endif
        @endforeach
    
    </div>
</body>
</html>
