<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6 text-gray-300">Aplicativo</h1>
        <p class="text-lg text-center mb-6 text-gray-300">Escolha uma das opções:</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">            
            <!-- Card 4: Calcular Preço -->
            <div class="bg-white p-4 border rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <a href="{{ route('shopping_lists.create') }}" class="block text-center">
                    <div class="flex justify-center items-center mb-4">
                        <!-- Heroicon SVG (Example) -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>                                                    
                    </div>
                    <span class="block text-xl font-semibold text-blue-500 hover:text-blue-700">
                        Solicitar compra
                    </span>
                </a>
            </div>
             <!-- Card 4: Calcular Preço -->
             <div class="bg-white p-4 border rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <a href="{{ route('shopping_lists.index') }}" class="block text-center">
                    <div class="flex justify-center items-center mb-4">
                        <!-- Heroicon SVG (Example) -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>                                                                           
                    </div>
                    <span class="block text-xl font-semibold text-blue-500 hover:text-blue-700">
                        Lista de compra
                    </span>
                </a>
            </div>                        
        </div>
    </div>
</x-app-layout>