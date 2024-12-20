@php
    use \Milon\Barcode\DNS1D;

    $d = new DNS1D();
    $d->setStorPath(__DIR__.'/cache/');

    // Garantir que o ID seja composto apenas por números
    $barcodeValue = preg_replace('/\D/', '', $retirada->id); 
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Retirada de Patrimônio</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .details {
            margin-bottom: 20px;
        }
        .details table {
            width: 100%;
            border-collapse: collapse;
        }
        .details table, .details th, .details td {
            border: 1px solid #000;
        }
        .details th, .details td {
            padding: 8px;
            text-align: left;
        }
        .grupos, .patrimonios {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .checkbox-column, .signature-column {
            width: 50px;
            text-align: center;
        }
        .signature {
            margin-top: 40px;
            text-align: center;
        }
        .signature-line {
            margin-top: 10px;
            border-top: 1px solid #000;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }
        .barcode {
            margin-left: auto;
            margin-right: 0;
        }
    </style>
</head>
<body>

    <div class="header">
        <br>
        <h1>Relatório de Retirada de Patrimônio - {{ $retirada->id}}</h1>
        <!-- Gerar o código de barras -->
        <div class="barcode">
            <div style="margin-top: -60px; margin-left:75%">
                @php
                    echo $d->getBarcodeHTML($barcodeValue, 'UPCA')
                @endphp
            </div>
        </div>
    </div>

    <div class="details">
        <h3>Informações da Retirada</h3>
        <table>
            <tr>
                <th>Responsável</th>
                <td>{{ $retirada->responsavel->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Técnico</th>
                <td>{{ $retirada->tecnicoResponsavel->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Anotações</th>
                <td>{{ $retirada->anotacoes ?? 'Nenhuma anotação' }}</td>
            </tr>
        </table>
    </div>

    @php
        $exibirGrupos = is_array(json_decode($retirada->grupos, true)) && count(json_decode($retirada->grupos, true)) > 0;
        $patrimonios = str_replace('"', '', $retirada->patrimonios);
        $patrimoniosArray = explode(',', $patrimonios);
        $exibirPatrimonios = is_array($patrimoniosArray) && count($patrimoniosArray) > 0;
    @endphp

    @if ($exibirGrupos)
        <div class="grupos">
            <h3>Grupos de Patrimônios</h3>
            <table>
                <thead>
                    <tr>
                        <th>Check-out</th>
                        <th>Check-in</th>
                        <th>Nome do Item</th>
                        <th>Código de Série</th>                
                    </tr>
                </thead>
                <tbody>
                    @foreach (json_decode($retirada->grupos, true) as $grupoId)
                        @php
                            $grupo = $grupoAll->firstWhere('id', $grupoId);
                        @endphp
                        @if ($grupo)
                            <tr>
                                <td colspan="4" style="text-align: center">Código: {{ $grupo->id ?? 'ID não disponível' }} -  {{ $grupo->nome ?? 'Nome não disponível' }}</td>
                            </tr>
                            @php
                                $itensGrupo = $itemsgrupoAll->where('id_grupo_patrimonio', $grupo->id);
                            @endphp
                            @foreach ($itensGrupo as $item)
                                <tr>
                                    <td class="checkbox-column"><input type="checkbox"></td>
                                    <td class="checkbox-column"><input type="checkbox"></td>
                                    <td>{{ $item->nome ?? 'Nome não disponível' }}</td>
                                    <td>{{ $item->serie ?? 'Série não disponível' }}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    
    @if ($patrimoniosArray[0] != 'null')
        <div class="patrimonios">
            <h3>Patrimônios Retirados</h3>
            <table>
                <thead>
                    <tr>
                        <th>Check-out</th>
                        <th>Check-in</th>
                        <th>Nome do Patrimônio</th>
                        <th>Código</th>
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
                            <tr>
                                <td class="checkbox-column"><input type="checkbox"></td>
                                <td class="checkbox-column"><input type="checkbox"></td>
                                <td>{{ $patrimonio->nome_completo ?? 'Nome não disponível' }}</td>
                                <td>{{ $codigoSerie ?? 'Código não disponível' }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="signature-container" style="width: 100%; display: table;">
        <div style="display: table-row;">
            <!-- Coluna 1: Saída -->
            <div class="signature" style="display: table-cell; width: 50%; text-align: center;">
                <p>Assinatura do Técnico Responsável - Saída</p>
                <br>
                <div class="signature-line" style="border-top: 1px solid #000; width: 200px; margin-left: auto; margin-right: auto;"></div>
                <br>
                <p>Assinatura do Responsável - Saída</p>
                <br>
                <div class="signature-line" style="border-top: 1px solid #000; width: 200px; margin-left: auto; margin-right: auto;"></div>
            </div>
    
            <!-- Coluna 2: Retorno -->
            <div class="signature" style="display: table-cell; width: 50%; text-align: center;">
                <p>Assinatura do Técnico Responsável - Retorno</p>
                <br>
                <div class="signature-line" style="border-top: 1px solid #000; width: 200px; margin-left: auto; margin-right: auto;"></div>
                <br>
                <p>Assinatura do Responsável - Retorno</p>
                <br>
                <div class="signature-line" style="border-top: 1px solid #000; width: 200px; margin-left: auto; margin-right: auto;"></div>
            </div>
        </div>
    </div>
    
    
    

</body>
</html>
