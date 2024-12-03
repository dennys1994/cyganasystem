<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6 text-gray-300">Editar Credenciais de Usuário</h1>

        <form action="{{ route('relatorio.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nome -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-300">Nome</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                       required>
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- E-mail -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-300">E-mail</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                       required>
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- auth_sige -->
            <div class="mb-4">
                <label for="auth_sige" class="block text-sm font-medium text-gray-300">Auth Sige</label>
                <input type="text" name="auth_sige" id="auth_sige" value="{{ old('auth_sige', $user->auth_sige) }}"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @error('auth_sige') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- app_name -->
            <div class="mb-4">
                <label for="app_name" class="block text-sm font-medium text-gray-300">Nome do App</label>
                <input type="text" name="app_name" id="app_name" value="{{ old('app_name', $user->app_name) }}"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @error('app_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- auth_milvus -->
            <div class="mb-4">
                <label for="auth_milvus" class="block text-sm font-medium text-gray-300">Auth Milvus</label>
                <input type="text" name="auth_milvus" id="auth_milvus" value="{{ old('auth_milvus', $user->auth_milvus) }}"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @error('auth_milvus') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Botão de Atualizar -->
            <div class="mt-6">
                <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Atualizar Usuário
                </button>
            </div>
        </form>

        <div class="mt-4">
            <a href="{{ route('relatorio.users.list') }}" class="text-blue-500 hover:text-blue-700">
                < Voltar para a lista de usuários
            </a>
        </div>
    </div>
</x-app-layout>
