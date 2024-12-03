<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6 text-white">Criar Credenciais</h1>
        <p class="text-lg text-center mb-6 text-gray-400">Preencha as informações abaixo para criar novas credenciais.</p>

        <!-- Formulário de cadastro -->
        <div class="max-w-lg mx-auto bg-gray-800 p-6 rounded-lg shadow-md">
            <!-- Verificar se há erros de validação -->
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 mb-4 rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('relatorio.create.user') }}" method="POST">
                @csrf
                <!-- Nome -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-300 font-semibold">Nome</label>
                    <input type="text" id="name" name="name" class="mt-2 p-2 w-full border border-gray-600 bg-gray-700 text-white rounded-md focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- E-mail -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-300 font-semibold">E-mail</label>
                    <input type="email" id="email" name="email" class="mt-2 p-2 w-full border border-gray-600 bg-gray-700 text-white rounded-md focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- auth_sige -->
                <div class="mb-4">
                    <label for="auth_sige" class="block text-gray-300 font-semibold">Auth Sige</label>
                    <input type="text" id="auth_sige" name="auth_sige" class="mt-2 p-2 w-full border border-gray-600 bg-gray-700 text-white rounded-md focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- app_name -->
                <div class="mb-4">
                    <label for="app_name" class="block text-gray-300 font-semibold">Nome do Aplicativo</label>
                    <input type="text" id="app_name" name="app_name" class="mt-2 p-2 w-full border border-gray-600 bg-gray-700 text-white rounded-md focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- auth_milvus -->
                <div class="mb-4">
                    <label for="auth_milvus" class="block text-gray-300 font-semibold">Auth Milvus</label>
                    <input type="text" id="auth_milvus" name="auth_milvus" class="mt-2 p-2 w-full border border-gray-600 bg-gray-700 text-white rounded-md focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Botão de Submissão -->
                <div class="mb-4 text-center">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Criar Credenciais</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
