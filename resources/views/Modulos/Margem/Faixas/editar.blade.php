<x-app-layout>
    <div class="container mx-auto p-6 bg-gray-800 text-gray-100 rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold mb-6">Editar Faixa de Preço</h1>

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

        <form action="{{ route('margem.faixas.atualizar', $faixa->id) }}" method="POST">
            @csrf

            <!-- Categoria -->
            <div class="mb-6">
                <label for="categoria_id" class="block text-sm font-medium text-gray-300">Categoria</label>
                <select id="categoria_id" name="categoria_id" 
                        class="mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-black">
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ $faixa->categoria_id == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Faixa Inicial -->
            <div class="mb-6">
                <label for="min" class="block text-sm font-medium text-gray-300">Faixa Inicial</label>
                <input type="number" id="min" name="min" value="{{ old('min', $faixa->min) }}"
                       class="mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-black">
            </div>

            <!-- Faixa Final -->
            <div class="mb-6">
                <label for="max" class="block text-sm font-medium text-gray-300">Faixa Final</label>
                <input type="number" id="max" name="max" value="{{ old('max', $faixa->max) }}"
                       class="mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-black">
            </div>

            <!-- À Vista -->
            <div class="mb-6">
                <label for="avista" class="block text-sm font-medium text-gray-300">Percentual à Vista</label>
                <input type="number" id="avista" name="avista" value="{{ old('avista', $faixa->avista) }}"
                       class="mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-black">
            </div>

            <!-- Parcelado -->
            <div class="mb-6">
                <label for="parcelado" class="block text-sm font-medium text-gray-300">Percentual Parcelado</label>
                <input type="number" id="parcelado" name="parcelado" value="{{ old('parcelado', $faixa->parcelado) }}"
                       class="mt-1 block w-full px-4 py-3 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-black">
            </div>

            <!-- Botão -->
            <div class="mt-6">
                <button type="submit" class="w-full py-3 px-6 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Atualizar Faixa de Preço
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
