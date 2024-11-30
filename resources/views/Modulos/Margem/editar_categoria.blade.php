<x-app-layout>
    <div class="container mx-auto p-6 bg-gray-800 text-gray-100 rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold mb-6">Editar Categoria</h1>

        @if (session('success'))
            <div class="mb-4 p-4 text-green-800 bg-green-100 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 text-red-800 bg-red-100 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('margem.categorias.atualizar', $categoria->id) }}" method="POST">
            @csrf

            <!-- Nome -->
            <div class="mb-6">
                <label for="nome" class="block text-sm font-medium text-">Nome</label>
                <input type="text" id="nome" name="nome" value="{{ old('nome', $categoria->nome) }}"
                       class="text-black mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <!-- Mão de Obra Fixo -->
            <div class="mb-6">
                <label for="maodeobra_fixo" class="block text-sm font-medium text-gray-300">Mão de Obra Fixa</label>
                <div class="flex">
                    <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                        R$
                    </span>
                    <input type="number" step="0.01" id="maodeobra_fixo" name="maodeobra_fixo" 
                           value="{{ old('maodeobra_fixo', $categoria->maodeobra_fixo) }}" 
                           class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
            </div>

            <!-- Botão -->
            <div class="mt-6">
                <button type="submit" class="w-full py-3 px-6 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Atualizar Categoria
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
