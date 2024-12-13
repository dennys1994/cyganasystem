<x-app-layout>
    <div class="container mx-auto p-6 bg-gray-800 text-black rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold text-gray-100 mb-6">Calcular Preço</h1>

        @if (session('success'))
            <div class="mb-4 p-4 text-green-800 bg-green-100 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 text-red-800 bg-red-100 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

         <!-- Exibe erros de faixa -->
         @if (isset($error))
            <div class="mb-4 p-4 text-red-800 bg-red-100 rounded-lg">
                {{ $error }}
            </div>
        @endif    

        <form action="{{ route('margem.calcular_preco') }}" method="POST">
            @csrf

            <!-- Categoria de Serviço -->
            <div class="mb-6">
                <label for="categoria_id" class="block text-sm font-medium text-gray-300">Categoria de Serviço</label>
                <select name="categoria_id" id="categoria_id" class="mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Selecione uma Categoria</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Preço de Custo -->
            <div class="mb-6">
                <label for="preco_custo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Preço de Custo</label>
                <div class="flex">                    
                    <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                        R$
                    </span>
                    <input type="text" 
                    id="preco_custo" 
                    name="preco_custo" 
                    class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                    placeholder="Digite o preço (ponto ou vírgula)">                          
                </div>
            </div>

            <!-- Frete -->
            <div class="mb-6">
                <label for="frete" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Frete</label>
                <div class="flex">
                    <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                        R$
                    </span>
                    <input type="number" id="frete" name="frete" value="0" class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
            </div>

            <!-- Botão -->
            <div class="mt-6">
                <button type="submit" class="w-full py-3 px-6 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Calcular Preço
                </button>
            </div>
        </form>

         <!-- Exibição dos resultados -->
         @if (isset($resultados))
            <div class="mt-8 p-6 bg-gray-700 text-gray-200 rounded-md shadow-md">
                <h2 class="text-xl font-bold mb-4">Resultados</h2>
                <p><strong>Custo:</strong> R$ {{ $resultados['custo'] }}</p>
                <p><strong>Venda à Vista:</strong> R$ {{ $resultados['avista'] }}</p>
                <p><strong>Venda Parcelado:</strong> 10 x R$ {{ $resultados['parcelado'] }} ({{$resultados['parcelado_cheio']}})</p>
                <p><strong>Margem:</strong> R$ {{ $resultados['margem'] }}</p>
                <p><strong>Margem Percentual:</strong> {{ $resultados['margem_percentual'] }}%</p>
                <div class="mt-4 text-center">
                    <p class="text-lg font-semibold text-red-400">Desconto Especial? Só apertar o botão!</p>
                    <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank" class="mt-4 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                        Aplicar Desconto
                    </a>
                </div>              
            </div>
        @endif
        <div class="mt-6 text-center">
            <a href="{{ route('financeiro.index') }}" class="inline-block px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600">
                Voltar para o Financeiro
            </a>
        </div>
    
    </div>
    <script>
        const inputPrecoCusto = document.getElementById('preco_custo');
    
        inputPrecoCusto.addEventListener('input', (e) => {
            // Substitui vírgulas por pontos para uniformizar o formato decimal
            const valor = e.target.value.replace(',', '.');
            
            // Permite apenas números e um único ponto decimal
            if (!/^\d*\.?\d*$/.test(valor)) {
                e.target.value = e.target.value.slice(0, -1);
            } else {
                e.target.value = valor;
            }
        });
    
        inputPrecoCusto.addEventListener('blur', (e) => {
            // Conversão de número para o formato correto, se necessário
            const valor = parseFloat(e.target.value);
            if (!isNaN(valor)) {
                e.target.value = valor.toFixed(2); // Formato com 2 casas decimais
            }
        });
    </script>
</x-app-layout>
