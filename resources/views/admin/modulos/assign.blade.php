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

        <!-- Formulário para atribuir módulos -->
        <form action="{{ route('modulos.assign') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Campo de Usuário -->
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-300">Usuário:</label>
                <select id="user_id" name="user_id" required
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Campo de Módulos -->
            <div>
                <label for="modulos" class="block text-sm font-medium text-gray-300">Módulos:</label>
                <select id="modulos" name="modulos[]" multiple required
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none">
                    @foreach($modulos as $modulo)
                        <option value="{{ $modulo->id }}">{{ $modulo->nome }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Campo de Permissão -->
            <div>
                <label for="permissao" class="block text-sm font-medium text-gray-300">Permissão:</label>
                <select id="permissao" name="permissao" required
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none">
                    <option value="acesso">Acesso</option>
                    <option value="leitura">Leitura</option>
                    <option value="administrativo">Administrativo</option>
                </select>
            </div>

            <!-- Botão de Enviar -->
            <div>
                <button type="submit" 
                    class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                    Atribuir Módulos
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
