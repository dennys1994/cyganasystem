<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6 text-gray-300">Margem</h1>
        <p class="text-lg text-center mb-6 text-gray-300">Escolha uma das opções:</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
             
            @if(Auth::check() && Auth::user()->role_id == 1)
                <!-- Card 5: Editar Categoria -->
                <div class="bg-white p-4 border rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <a href="{{ route('relatorio.users.index') }}" class="block text-center"> <!-- Substitua "1" pelo ID da categoria que você quer editar -->
                        <div class="flex justify-center items-center mb-4">
                            <!-- Heroicon SVG (Example) -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                            </svg>                              
                        </div>
                        <span class="block text-xl font-semibold text-blue-500 hover:text-blue-700">
                            Adicionar credenciais
                        </span>
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>