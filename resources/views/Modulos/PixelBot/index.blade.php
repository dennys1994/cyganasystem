<x-app-layout>
    <div class="max-w-6xl mx-auto mt-8">
        <div class="bg-gray-800 p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-white mb-4">Empresas</h2>

            @if (session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ route('empresa.create') }}" class="bg-indigo-600 text-white py-2 px-4 rounded mb-4 inline-block hover:bg-indigo-700">
                Adicionar Empresa
            </a>
            <a href="{{ route('dados-digisac.index') }}" class="bg-indigo-600 text-white py-2 px-4 rounded mb-4 inline-block hover:bg-indigo-700">
                Credenciais Digisac
            </a>


            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Nome Empresa</th>
                            <th scope="col" class="px-6 py-3">ID Milvus</th>
                            <th scope="col" class="px-6 py-3">ID Digisac</th>
                            <th scope="col" class="px-6 py-3">Máx. Horas</th>
                            <th scope="col" class="px-6 py-3">Responsável Digisac</th>
                            <th scope="col" class="px-6 py-3">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($empresas as $empresa)
                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $empresa->id }}</td>
                                <td class="px-6 py-4">{{ $empresa->nome }}</td>
                                <td class="px-6 py-4">{{ $empresa->id_milvus }}</td>
                                <td class="px-6 py-4">{{ $empresa->id_digisac }}</td>
                                <td class="px-6 py-4">{{ $empresa->num_max_horas }}</td>
                                <td class="px-6 py-4">{{ $empresa->id_responsavel_digisac }}</td>
                                <td class="px-6 py-4 flex items-center space-x-4">
                                    <a href="{{ route('empresa.edit', $empresa->id) }}" class="font-medium text-blue-600 hover:underline">Editar</a>
                                    <form action="{{ route('empresa.destroy', $empresa->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-red-600 hover:underline">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
