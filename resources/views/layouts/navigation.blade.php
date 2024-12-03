<nav x-data="{ open: false, openAdmin: false, openFuncoes: false, openPerfil: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">            
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                 

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:space-x-8 sm:ml-10">
                    
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @if(Auth::check() && Auth::user()->role_id == 1)
                        <button @click="openAdmin = !openAdmin" type="button" class="inline-flex items-center gap-x-1 text-sm font-semibold text-gray-900" aria-expanded="false">
                            <x-nav-link>
                                {{ __('Admin') }}
                            </x-nav-link>
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                        </button>
                        
                        <div x-show="openAdmin" x-transition class="absolute left-1/2 z-10 mt-5 flex w-screen max-w-max -translate-x-1/2 px-4" style="margin-top: 50px;">
                            <div class="w-screen max-w-md flex-auto overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-900/5">
                                <div class="p-4">
                                <!-- Dropdown items -->
                                    <!-- 1° item -->
                                    <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50">
                                        <a href="{{route ('roles.create')}}" >
                                            <div class="mt-1 flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                                </svg>                                                                                    
                                            </div>
                                            <div>
                                                <a href="{{route ('roles.create')}}" class="font-semibold text-gray-900">
                                                    Criar Tipo Usuário
                                                    <p class="mt-1 text-gray-600">Criar tipo para limitar usuários</p>
                                                </a>                                        
                                            </div>  
                                        </a>                         
                                    </div> 
                                    <!-- Final 1° item -->    
                                    <!-- 2° item -->
                                    <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50">
                                        <a href="{{route ('user.create')}}" >
                                            <div class="mt-1 flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                                                </svg>                                                                                                                                 
                                            </div>
                                            <div>
                                                <a href="{{route ('user.create')}}" class="font-semibold text-gray-900">
                                                    Cadastrar usuário
                                                    <p class="mt-1 text-gray-600">Criar usuários</p>
                                                </a>                                        
                                            </div>  
                                        </a>                         
                                    </div> 
                                    <!-- Final 2° item -->      
                                    <!-- 2° item -->
                                    <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50">
                                        <a href="{{route ('modulos.create')}}" >
                                            <div class="mt-1 flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 0 1-.657.643 48.39 48.39 0 0 1-4.163-.3c.186 1.613.293 3.25.315 4.907a.656.656 0 0 1-.658.663v0c-.355 0-.676-.186-.959-.401a1.647 1.647 0 0 0-1.003-.349c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401v0c.31 0 .555.26.532.57a48.039 48.039 0 0 1-.642 5.056c1.518.19 3.058.309 4.616.354a.64.64 0 0 0 .657-.643v0c0-.355-.186-.676-.401-.959a1.647 1.647 0 0 1-.349-1.003c0-1.035 1.008-1.875 2.25-1.875 1.243 0 2.25.84 2.25 1.875 0 .369-.128.713-.349 1.003-.215.283-.4.604-.4.959v0c0 .333.277.599.61.58a48.1 48.1 0 0 0 5.427-.63 48.05 48.05 0 0 0 .582-4.717.532.532 0 0 0-.533-.57v0c-.355 0-.676.186-.959.401-.29.221-.634.349-1.003.349-1.035 0-1.875-1.007-1.875-2.25s.84-2.25 1.875-2.25c.37 0 .713.128 1.003.349.283.215.604.401.96.401v0a.656.656 0 0 0 .658-.663 48.422 48.422 0 0 0-.37-5.36c-1.886.342-3.81.574-5.766.689a.578.578 0 0 1-.61-.58v0Z" />
                                                </svg>                                                                                                                                                                                                                           
                                            </div>
                                            <div>
                                                <a href="{{route ('modulos.create')}}" class="font-semibold text-gray-900">
                                                    Criar modulos
                                                    <p class="mt-1 text-gray-600">Criar novas funções para o sistema (dev)</p>
                                                </a>                                        
                                            </div>  
                                        </a>                         
                                    </div> 
                                    <!-- Final 2° item -->      
                                    <!-- 2° item -->
                                    <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50">
                                        <a href="{{route ('modulos.assign')}}" >
                                            <div class="mt-1 flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m3-3H9m4.06-7.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                                                </svg>                                                                                                                                                                              
                                            </div>
                                            <div>
                                                <a href="{{route ('modulos.assign')}}" class="font-semibold text-gray-900">
                                                    indexar modulos
                                                    <p class="mt-1 text-gray-600">Adicionar modulos para tipos de usuários</p>
                                                </a>                                        
                                            </div>  
                                        </a>                         
                                    </div> 
                                    <!-- Final 2° item -->                                                     
                                </div>
                            </div>                                   
                        </div>  
                    @endif
                    <!-- Final menu admin -->
                    <!--Segundo menu-->
                    <button @click="openFuncoes = !openFuncoes" type="button" class="inline-flex items-center gap-x-1 text-sm font-semibold text-gray-900" aria-expanded="false">
                        <x-nav-link>
                            {{ __('Funções') }}
                        </x-nav-link>
                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                      </svg>
                    </button>
                    
                    <div x-show="openFuncoes" x-transition class="absolute left-1/2 z-10 mt-5 flex w-screen max-w-max -translate-x-1/2 px-4" style="margin-top: 50px;">
                        <div class="w-screen max-w-md flex-auto overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-900/5">
                            <div class="p-4">
                            <!-- Dropdown items -->
                                <!-- 1° item -->
                                @if($hasAccessToMargem)
                                    <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50">
                                        <a href="{{route ('margem.index')}}" >
                                            <div class="mt-1 flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                                </svg>                                                                                                                             
                                            </div>
                                            <div>
                                                <a href="{{route ('margem.index')}}" class="font-semibold text-gray-900">
                                                    Relatorio de fechamento
                                                    <p class="mt-1 text-gray-600">Calcular margens de venda / lucro</p>
                                                </a>                                        
                                            </div>  
                                        </a>                         
                                    </div>    
                                 @endif   
                                <!-- Final 1° item -->
                                @if(Auth::check() && Auth::user()->role_id == 1)
                                <!-- 2° item -->                            
                                    <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50">
                                        <a href="{{route ('relatorio')}}" >
                                            <div class="mt-1 flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                                                </svg>                                                                                                                                                                              
                                            </div>
                                            <div>
                                                <a href="{{route ('relatorio')}}" class="font-semibold text-gray-900">
                                                    Relatorio Fechamento
                                                    <p class="mt-1 text-gray-600">Fazer fechamento do mês via Api Sige e Api Milvus</p>
                                                </a>                                        
                                            </div>  
                                        </a>                         
                                    </div>    
                                 @endif   
                                <!-- Final 2° item -->                                                
                            </div>
                        </div>                                   
                    </div>                          
                </div>
            </div>
            
            <!-- Settings Dropdown (Nome do usuário) -->
            <div class="hidden sm:flex sm:items-center ml-auto"> <!-- Aqui foi adicionada a classe ml-auto -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Logout') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>                
        </div>
        <!-- Hamburger Menu -->
        <div class="flex justify-self-end sm:hidden">
            <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div x-show="open" class="sm:hidden" x-cloak>
        <div class="pt-2 pb-3 space-y-1">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-nav-link>
            @if(Auth::check() && Auth::user()->role_id == 1)
                <button @click="openAdmin = !openAdmin" class="block w-full text-left px-4 py-2 text-gray-200 hover:bg-gray-100 hover:text-black">
                    {{ __('Admin') }}
                    <svg class="w-5 h-5 inline" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="openAdmin" class="pl-4 space-y-1" x-cloak>
                    <a href="{{ route('roles.create') }}" class="block text-sm text-gray-200 hover:bg-gray-100">{{ __('Criar Tipo Usuário') }}</a>
                    <a href="{{ route('user.create') }}" class="block text-sm text-gray-200 hover:bg-gray-100">{{ __('Cadastrar Usuário') }}</a>
                    <a href="{{ route('modulos.create') }}" class="block text-sm text-gray-200 hover:bg-gray-100">{{ __('Criar Módulos') }}</a>
                    <a href="{{ route ('modulos.assign')}}" class="block text-sm text-gray-200 hover:bg-gray-100">{{ __('Indexar Módulos') }}</a>
                </div>
            @endif
            <button @click="openFuncoes = !openFuncoes" class="block w-full text-left px-4 py-2 text-gray-200 hover:bg-gray-100 hover:text-black">
                {{ __('Funções') }}
                <svg class="w-5 h-5 inline" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
            </button>
            <div x-show="openFuncoes" class="pl-4 space-y-1" x-cloak>
                <a href="{{route ('margem.index')}}" class="block text-sm text-gray-200 hover:bg-gray-100">{{ __('Margens') }}</a>                   
            </div>
            
            <button @click="openPerfil = !openPerfil" class="block w-full text-left px-4 py-2 text-gray-200 hover:bg-gray-100 hover:text-black">
                {{ Auth::user()->name }}
                <svg class="w-5 h-5 inline" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
            </button>
            <div x-show="openPerfil" class="pl-4 space-y-1" x-cloak>
                <a href="{{route('profile.edit')}}" class="block text-sm text-gray-200 hover:bg-gray-100">{{ __('Perfil') }}</a>                   
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="block text-sm text-gray-200 hover:bg-gray-100">
                        {{ __('Logout') }}
                    </button>
                </form>                     
            </div>
        </div>
    </div>
</nav>