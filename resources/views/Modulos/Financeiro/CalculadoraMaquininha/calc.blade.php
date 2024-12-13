<x-app-layout>
    <div class="max-w-4xl mx-auto mt-8 bg-gray-800 p-6 rounded-lg shadow-md">
        <h3 class="text-2xl font-semibold text-white">Calculadora de Taxas</h3>

        <!-- Exibição de mensagem de erro -->
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulário para calcular as taxas -->
        <form action="{{ route('calculadora.calcular') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="bandeira_id" class="block text-sm font-medium text-gray-300">Selecione a Bandeira:</label>
                <select name="bandeira_id" id="bandeira_id" class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-md">
                    <option value="">Selecione</option>
                    @foreach ($bandeiras as $bandeira)
                        <option value="{{ $bandeira->id }}" {{ old('bandeira_id') == $bandeira->id ? 'selected' : '' }}>
                            {{ $bandeira->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="valor" class="block text-sm font-medium text-gray-300">Valor a ser Parcelado:</label>
                <input type="text" name="valor" value="{{ old('valor') }}" class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-md">
            </div>

            <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                Calcular Taxas
            </button>
        </form>

        <!-- Exibição dos resultados -->
        @if (isset($resultados))
            <div class="mt-6">
                <h4 class="text-xl font-semibold text-white">Resultados</h4>
                <table class="min-w-full bg-gray-700 mt-4">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-gray-300">Parcelas</th>
                            <th class="px-4 py-2 text-left text-gray-300">Valor Total</th>
                            <th class="px-4 py-2 text-left text-gray-300">Valor por Parcela</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resultados as $resultado)
                            <tr>
                                <td class="px-4 py-2 text-gray-300">{{ $resultado['parcelas'] }}x</td>
                                <td class="px-4 py-2 text-gray-300">R$ {{ $resultado['valorTotal'] }}</td>
                                <td class="px-4 py-2 text-gray-300">R$ {{ $resultado['valorParcela'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
