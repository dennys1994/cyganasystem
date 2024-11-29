<x-app-layout>    
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
    <div class="container mx-auto p-6 bg-gray-900 text-white rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold mb-6">Criar Novo Módulo</h2>
        
        <form action="{{ route('modulos.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="form-group">
                <label for="nome" class="block text-lg font-semibold mb-2">Nome</label>
                <input type="text" id="nome" name="nome" required 
                       class="w-full p-3 bg-gray-800 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div class="form-group">
                <label for="descricao" class="block text-lg font-semibold mb-2">Descrição</label>
                <textarea id="descricao" name="descricao" 
                          class="w-full p-3 bg-gray-800 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div class="form-group">
                <label for="ativo" class="block text-lg font-semibold mb-2">Ativo</label>
                <select id="ativo" name="ativo" 
                        class="w-full p-3 bg-gray-800 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                </select>
            </div>

            <button type="submit" 
                    class="w-full p-3 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                Criar Módulo
            </button>
        </form>
    </div>
</x-app-layout>
