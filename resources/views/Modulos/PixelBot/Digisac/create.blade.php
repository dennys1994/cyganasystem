<x-app-layout>
    <div class="max-w-6xl mx-auto mt-8">
        <div class="bg-gray-800 p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-white mb-4">Adicionar Credenciais Digisac</h2>

            @if ($errors->any())
                <div class="bg-red-500 text-white p-4 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('dados-digisac.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="token" class="block text-white text-sm font-bold mb-2">Token</label>
                    <input type="text" name="token" id="token" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500" value="{{ old('token') }}">
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700">Salvar</button>
                    <a href="{{ route('dados-digisac.index') }}" class="text-white underline">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
