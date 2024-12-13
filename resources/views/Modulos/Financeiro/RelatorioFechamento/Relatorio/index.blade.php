<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6 text-gray-300">Relatorio de Fechamento</h1>
        <p class="text-lg text-center mb-6 text-gray-300">Escolha uma das opções:</p>
        @if(session('error'))
            <div class="text-red-500 text-center mb-4">
                {{ session('error') }}
            </div>
        @endif
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
             
            @if(Auth::check() && Auth::user()->role_id == 1)
                <!-- Card 5: Editar Categoria -->
                <div class="bg-white p-4 border rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <a href="{{ route('relatorio.clientes') }}" class="block text-center"> <!-- Substitua "1" pelo ID da categoria que você quer editar -->
                        <div class="flex justify-center items-center mb-4">
                            <!-- Heroicon SVG (Example) -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                            </svg>                                                            
                        </div>
                        <span class="block text-xl font-semibold text-blue-500 hover:text-blue-700">
                            Clientes
                        </span>
                    </a>
                </div>                
            @endif
        </div>
    </div>
</x-app-layout>