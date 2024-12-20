<x-app-layout>
    <div class="max-w-7xl mx-auto mt-8 bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-white">Códigos de Barras do Patrimônio: {{ $nome_completo }}</h2> <!-- Exibe o nome completo do patrimônio -->
        
        <div id="barcodes">
            @foreach ($series as $serie)
                <div class="my-4">
                    <label class="text-white">Código: {{ str_replace('-', '', $serie->codigo) }}</label>
                    <canvas id="barcode{{ $loop->index }}"></canvas>
                    <!-- Botão de Download individual -->
                    <button class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-600 mt-2" onclick="downloadBarcode('{{ str_replace('-', '', $serie->codigo) }}', 'barcode{{ $loop->index }}')">Baixar Código de Barras</button>
                </div>
            @endforeach
        </div>

        <!-- Botão para Download de todos os códigos de barras -->
        <button class="bg-green-500 text-white py-2 px-4 rounded mt-6" onclick="downloadAllBarcodes()">Baixar Todos os Códigos de Barras</button>

        <a href="{{ route('almoxarifado.index') }}" class="inline-block py-2 px-4 mt-6 text-white font-semibold bg-blue-600 rounded-md shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-400">
            Voltar
        </a>
    </div>

    <!-- Incluir JsBarcode e JSZip -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
    <script>
        // Gerando os códigos de barras
        @foreach ($series as $index => $serie)
            JsBarcode("#barcode{{ $index }}", "{{ str_replace('-', '', $serie->codigo) }}", {
                format: "CODE128",
                width: 2,
                height: 40,
                displayValue: true
            });
        @endforeach

        // Função para baixar o código de barras em PNG
        function downloadBarcode(codigo, id) {
            var canvas = document.getElementById(id);
            var dataURL = canvas.toDataURL("image/png");

            var link = document.createElement('a');
            link.href = dataURL;
            link.download = codigo + '.png';  // Nome do arquivo é o código sem os traços
            link.click();
        }

        // Função para baixar todos os códigos de barras em um arquivo ZIP
        function downloadAllBarcodes() {
            var zip = new JSZip();
            var barcodePromises = [];

            @foreach ($series as $index => $serie)
                barcodePromises.push(new Promise(function(resolve, reject) {
                    var canvas = document.getElementById('barcode{{ $index }}');
                    var dataURL = canvas.toDataURL("image/png");

                    // Adiciona o arquivo no ZIP
                    zip.file("{{ str_replace('-', '', $serie->codigo) }}.png", dataURL.split(',')[1], {base64: true});
                    resolve();
                }));
            @endforeach

            // Após todos os códigos de barras serem adicionados ao ZIP, fazer o download
            Promise.all(barcodePromises).then(function() {
                zip.generateAsync({type: "blob"}).then(function(content) {
                    var link = document.createElement('a');
                    link.href = URL.createObjectURL(content);
                    link.download = "codigos_de_barras.zip";  // Nome do arquivo ZIP
                    link.click();
                });
            });
        }
    </script>
</x-app-layout>
