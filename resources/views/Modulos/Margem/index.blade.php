<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6 text-gray-300">Margem</h1>
        <p class="text-lg text-center mb-6 text-gray-300">Escolha uma das opções:</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @if(Auth::check() && Auth::user()->role_id == 1)
                <!-- Card 1: Criar Categoria de Margem -->
                <div class="bg-white p-4 border rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <a href="{{ route('margem.create_categoria') }}" class="block text-center">
                        <div class="flex justify-center items-center mb-4">
                            <!-- Heroicon SVG (Example) -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>                         
                        </div>
                        <span class="block text-xl font-semibold text-blue-500 hover:text-blue-700">
                            Criar Categoria de Margem
                        </span>
                    </a>
                </div>

                <!-- Card 2: Criar Tabela de Margem -->
                <div class="bg-white p-4 border rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <a href="{{ route('margem.create_faixa') }}" class="block text-center">
                        <div class="flex justify-center items-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                            </svg>                           
                        </div>
                        <span class="block text-xl font-semibold text-blue-500 hover:text-blue-700">
                            Criar de Margem
                        </span>
                    </a>
                </div>
            @endif
            <!-- Card 4: Calcular Preço -->
            <div class="bg-white p-4 border rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <a href="{{ route('margem.calcular_preco') }}" class="block text-center">
                    <div class="flex justify-center items-center mb-4">
                        <!-- Heroicon SVG (Example) -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V13.5Zm0 2.25h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V18Zm2.498-6.75h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V13.5Zm0 2.25h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V18Zm2.504-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5Zm0 2.25h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V18Zm2.498-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5ZM8.25 6h7.5v2.25h-7.5V6ZM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.65 4.5 4.757V19.5a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25V4.757c0-1.108-.806-2.057-1.907-2.185A48.507 48.507 0 0 0 12 2.25Z" />
                        </svg>                          
                    </div>
                    <span class="block text-xl font-semibold text-blue-500 hover:text-blue-700">
                        Calcular Preço
                    </span>
                </a>
            </div>
            @if(Auth::check() && Auth::user()->role_id == 1)
                <!-- Card 5: Editar Categoria -->
                <div class="bg-white p-4 border rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <a href="{{ route('margem.categorias.index') }}" class="block text-center"> <!-- Substitua "1" pelo ID da categoria que você quer editar -->
                        <div class="flex justify-center items-center mb-4">
                            <!-- Heroicon SVG (Example) -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 5.487a2.25 2.25 0 0 1 3.182 0l.469.469a2.25 2.25 0 0 1 0 3.182L9.121 20.53a6.375 6.375 0 0 1-2.694 1.605l-3.363.96.96-3.362a6.375 6.375 0 0 1 1.605-2.694L16.862 5.487ZM5.25 11.25h.008v.008H5.25v-.008Zm1.5 1.5h.008v.008H6.75v-.008Zm2.25 2.25h.008v.008H9v-.008Z" />
                            </svg>
                        </div>
                        <span class="block text-xl font-semibold text-blue-500 hover:text-blue-700">
                            Editar Categoria
                        </span>
                    </a>
                </div>

                <!-- Card 6: Editar Faixa -->
                <div class="bg-white p-4 border rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <a href="{{ route('margem.faixas.index') }}" class="block text-center"> <!-- Substitua '1' pelo ID da faixa de preço que você quer editar -->
                        <div class="flex justify-center items-center mb-4">
                            <!-- Heroicon SVG (Example) -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 5.487a2.25 2.25 0 0 1 3.182 0l.469.469a2.25 2.25 0 0 1 0 3.182L9.121 20.53a6.375 6.375 0 0 1-2.694 1.605l-3.363.96.96-3.362a6.375 6.375 0 0 1 1.605-2.694L16.862 5.487ZM5.25 11.25h.008v.008H5.25v-.008Zm1.5 1.5h.008v.008H6.75v-.008Zm2.25 2.25h.008v.008H9v-.008Z" />
                            </svg>
                        </div>
                        <span class="block text-xl font-semibold text-blue-500 hover:text-blue-700">
                            Editar Faixa
                        </span>
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>