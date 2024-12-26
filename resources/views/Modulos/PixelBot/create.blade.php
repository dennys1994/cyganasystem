<x-app-layout>
    <div class="max-w-6xl mx-auto mt-8">
        <div class="bg-gray-800 p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-white mb-4">Adicionar Empresa</h2>

            <form action="{{ route('empresa.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="nome" class="block text-sm font-medium text-white">Nome Empresa</label>
                        <input type="text" name="nome" id="nome" class="block w-full mt-1 bg-gray-700 text-white border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                               value="{{ old('nome', $empresa->nome ?? '') }}">
                    </div>
                    <div>
                        <label for="id_milvus" class="block text-sm font-medium text-white">ID Milvus</label>
                        <input type="text" name="id_milvus" id="id_milvus" class="block w-full mt-1 bg-gray-700 text-white border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                               value="{{ old('id_milvus', $empresa->id_milvus ?? '') }}">
                    </div>
                
                    <div>
                        <label for="id_digisac" class="block text-sm font-medium text-white">ID Digisac</label>
                        <input type="text" name="id_digisac" id="id_digisac" class="block w-full mt-1 bg-gray-700 text-white border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                               value="{{ old('id_digisac', $empresa->id_digisac ?? '') }}">
                    </div>
                
                    <div>
                        <label for="num_max_horas" class="block text-sm font-medium text-white">Número Máx. Horas</label>
                        <input type="number" name="num_max_horas" id="num_max_horas" class="block w-full mt-1 bg-gray-700 text-white border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                               value="{{ old('num_max_horas', $empresa->num_max_horas ?? '') }}">
                    </div>
                
                    <div>
                        <label for="id_responsavel_digisac" class="block text-sm font-medium text-white">ID Responsável Digisac</label>
                        <input type="text" name="id_responsavel_digisac" id="id_responsavel_digisac" class="block w-full mt-1 bg-gray-700 text-white border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                               value="{{ old('id_responsavel_digisac', $empresa->id_responsavel_digisac ?? '') }}">
                    </div>
                </div>
                
                <button type="submit" class="mt-4 bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">
                    Salvar
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
