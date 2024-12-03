<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6 text-gray-300">Margem</h1>
        <p class="text-lg text-center mb-6 text-gray-300">Escolha uma das opções:</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
             
            @if(Auth::check() && Auth::user()->role_id == 1)
                <!-- Card 5: Editar Categoria -->
                <div class="bg-white p-4 border rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <a href="{{ route('relatorio.users.store') }}" class="block text-center"> <!-- Substitua "1" pelo ID da categoria que você quer editar -->
                        <div class="flex justify-center items-center mb-4">
                            <!-- Heroicon SVG (Example) -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                            </svg>                                                           
                        </div>
                        <span class="block text-xl font-semibold text-blue-500 hover:text-blue-700">
                            Criar credenciais
                        </span>
                    </a>
                </div>
                <!-- Card 5: Editar Categoria -->
                <div class="bg-white p-4 border rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <a href="{{ route('relatorio.users.list') }}" class="block text-center"> <!-- Substitua "1" pelo ID da categoria que você quer editar -->
                        <div class="flex justify-center items-center mb-4">
                            <!-- Heroicon SVG (Example) -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>                                                            
                        </div>
                        <span class="block text-xl font-semibold text-blue-500 hover:text-blue-700">
                            Listar credenciais
                        </span>
                    </a>
                </div>           
            @endif

        </div>
    </div>
</x-app-layout>