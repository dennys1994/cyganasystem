<x-app-layout>
    <div class="container mx-auto p-6 bg-gray-800 text-gray-100 rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold mb-6">Faixas de Preço</h1>

        @if (session('success'))
            <div class="mb-4 p-4 text-green-800 bg-green-100 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full text-left border-collapse border border-gray-600">
            <thead>
                <tr>
                    <th class="px-4 py-2 border border-gray-600">ID</th>
                    <th class="px-4 py-2 border border-gray-600">Categoria</th>
                    <th class="px-4 py-2 border border-gray-600">Faixa</th>
                    <th class="px-4 py-2 border border-gray-600">À Vista</th>
                    <th class="px-4 py-2 border border-gray-600">Parcelado</th>
                    <th class="px-4 py-2 border border-gray-600">Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($faixas as $faixa)
                    <tr class="border border-gray-600">
                        <td class="px-4 py-2">{{ $faixa->id }}</td>
                        <td class="px-4 py-2">{{ $faixa->categoriaMargem->nome }}</td>
                        <td class="px-4 py-2">{{ $faixa->min }} - {{ $faixa->max }}</td>
                        <td class="px-4 py-2">{{ $faixa->avista }}%</td>
                        <td class="px-4 py-2">{{ $faixa->parcelado }}%</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('margem.faixas.editar', $faixa->id) }}" 
                               class="py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Editar
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
