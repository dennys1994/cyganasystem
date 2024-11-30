<x-app-layout>
    <div class="container mx-auto p-6 bg-gray-800 text-gray-100 rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold mb-6">Selecionar Categoria para Editar</h1>

        @if (session('success'))
            <div class="mb-4 p-4 text-green-800 bg-green-100 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full text-left border-collapse border border-gray-600">
            <thead>
                <tr>
                    <th class="px-4 py-2 border border-gray-600">ID</th>
                    <th class="px-4 py-2 border border-gray-600">Nome</th>
                    <th class="px-4 py-2 border border-gray-600">Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categorias as $categoria)
                    <tr class="border border-gray-600">
                        <td class="px-4 py-2">{{ $categoria->id }}</td>
                        <td class="px-4 py-2">{{ $categoria->nome }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('margem.categorias.editar', $categoria->id) }}" 
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
