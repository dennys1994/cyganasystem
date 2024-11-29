<x-app-layout>
    <div class="max-w-2xl mx-auto mt-8 bg-gray-800 p-6 rounded-lg shadow-md">
        
        <!-- Exibição de mensagem de sucesso -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <!-- Exibição de mensagem de erro -->
        @if (session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Formulário de criação de tipo de usuário -->
        <form action="{{ route('roles.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Campo de nome do tipo de usuário -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300">Nome do Tipo de Usuário:</label>
                <input type="text" name="name" id="name" required
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none">
            </div>
            
            <!-- Campo de permissões -->
            <div>
                <label for="permissions" class="block text-sm font-medium text-gray-300">Permissões (JSON):</label>
                <textarea name="permissions" id="permissions" 
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none" 
                    rows="5"></textarea>
            </div>
            
            <!-- Botão de Enviar -->
            <div class="pt-4">
                <button type="submit" 
                    class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                    Criar Tipo de Usuário
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
