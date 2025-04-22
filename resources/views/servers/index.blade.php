<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Communauté - Gestion des serveurs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Masquer la barre latérale sur mobile */
        @media (max-width: 768px) {
            .mobile-hidden {
                display: none;
            }
            
            .mobile-menu-button {
                display: block;
            }
            
            main {
                margin-left: 0 !important;
                padding: 1rem;
            }
        }
    </style>
</head>
<body class="bg-gray-950 text-gray-100">
    <!-- Bouton menu mobile -->
    <button class="mobile-menu-button fixed top-4 left-4 z-50 bg-gray-800 p-3 rounded-lg md:hidden">
        <i class="fas fa-bars text-white"></i>
    </button>

    <!-- Barre de navigation verticale -->
    <nav class="mobile-hidden fixed left-0 top-0 h-screen w-64 bg-gray-900 flex flex-col py-4 space-y-4 z-40 transition-all duration-300">
        <!-- Contenu de la barre latérale -->
        <div class="flex-1 overflow-y-auto px-4">
            <a href="#" class="text-2xl text-gray-400 hover:text-white transition-colors mb-6">
                <i class="fas fa-home"></i>
            </a>

            @foreach ($userServers as $server)
    <a href="{{ route('servers.show', $server) }}" 
       class="block mb-2 p-2 rounded-lg hover:bg-gray-800 transition-colors">
       <div class="flex items-center gap-3">
           @if($server->image)
               <img src="{{ asset('storage/' . $server->image) }}" 
                    alt="Logo {{ $server->name }}" 
                    class="w-8 h-8 rounded-lg object-cover">
           @else
               <div class="bg-blue-600 w-8 h-8 rounded-lg flex items-center justify-center">
                   {{ substr($server->name, 0, 1) }}
               </div>
           @endif
           <span class="text-gray-300">{{ $server->name }}</span>
       </div>
    </a>
@endforeach
        </div>
        
        @role('admin')
        <div class="px-4">
            <a href="{{ route('servers.create') }}" 
               class="bg-green-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-green-500 transition-colors">
                <i class="fas fa-plus"></i>
                <span>Créer un serveur</span>
            </a>
        </div>
        @endrole
    </nav>

    <!-- Contenu principal -->
    <main class="ml-0 md:ml-64 p-4 md:p-6 transition-all duration-300">
        <!-- Header -->
        <header class="bg-gray-900 p-4 md:p-6 rounded-xl mb-6 flex flex-col md:flex-row gap-4 justify-between items-start md:items-center">
            <h1 class="text-xl md:text-2xl font-bold flex items-center gap-2">
                <i class="fas fa-server"></i>
                Gestion des serveurs
            </h1>
            
            <div class="flex gap-2 w-full md:w-auto">
                <button class="bg-gray-800 px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors flex-1 md:flex-none">
                    <i class="fas fa-search"></i>
                    <span class="ml-2 md:hidden">Rechercher</span>
                </button>
                <button class="bg-blue-600 px-4 py-2 rounded-lg hover:bg-blue-500 transition-colors flex-1 md:flex-none">
                    <i class="fas fa-bell"></i>
                    <span class="ml-2 md:hidden">Notifications</span>
                </button>
            </div>
        </header>

        <div class="container mx-auto px-4 py-6">
    <!-- Mes communautés -->
    <section class="mb-8">
        <h2 class="text-lg md:text-xl font-semibold mb-4 flex items-center gap-2">
            <i class="fas fa-users"></i>
            Mes communautés
        </h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            @foreach ($userServers as $server)
                <div class="bg-gray-900 p-4 rounded-xl hover:bg-gray-800 transition-colors">
                    <div class="flex items-center gap-2 mb-2">
                        @if($server->image)
                            <img src="{{ asset('storage/' . $server->image) }}" 
                                 alt="Logo {{ $server->name }}" 
                                 class="w-8 h-8 rounded-lg object-cover">
                        @else
                            <div class="bg-blue-600 w-8 h-8 rounded-lg flex items-center justify-center">
                                {{ substr($server->name, 0, 1) }}
                            </div>
                        @endif
                        <h3 class="text-md md:text-lg font-semibold">{{ $server->name }}</h3>
                    </div>
                    <p class="text-xs md:text-sm text-gray-400 mb-4">{{ $server->short_description }}</p>
                    
                    <div class="flex gap-2">
                        <a href="{{ route('servers.show', $server) }}" 
                           class="flex-1 bg-blue-600 text-center py-2 rounded-lg hover:bg-blue-500 transition-colors text-sm md:text-base">
                            Accéder
                        </a>
                        @role('admin')
                        <form action="{{ route('servers.destroy', $server) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-10 bg-red-600 rounded-lg hover:bg-red-500 transition-colors">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endrole
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>

        <!-- Section Serveurs publics -->
        <section>
        <h2 class="text-lg md:text-xl font-semibold mb-4 flex items-center gap-2">
            <i class="fas fa-users"></i>
             Explorer les communautés    
        </h2>
<!-- Dans la section "Explorer les communautés" -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
    @foreach ($allServers as $server)
        <div class="bg-gray-900 p-4 rounded-xl hover:bg-gray-800 transition-colors">
            <!-- Logo et titre -->
            <div class="flex items-center gap-2 mb-2">
                @if($server->image)
                    <img src="{{ asset('storage/' . $server->image) }}" 
                         class="w-8 h-8 rounded-lg object-cover">
                @else
                    <div class="bg-blue-600 w-8 h-8 rounded-lg flex items-center justify-center">
                        {{ substr($server->name, 0, 1) }}
                    </div>
                @endif
                <h3 class="text-md md:text-lg font-semibold">{{ $server->name }}</h3>
            </div>
            <p class="text-xs md:text-sm text-gray-400 mb-4">{{ $server->short_description }}</p>

            <!-- Formulaire conditionnel -->
            <form action="{{ route('servers.join') }}" method="POST">
                @csrf
                <input type="hidden" name="server_id" value="{{ $server->id }}">

                <!-- Code (si présent) -->
                @if($server->code)
                    <div class="mb-2">
                        <input type="text" 
                               name="code" 
                               placeholder="Code d'accès" 
                               class="w-full bg-gray-800 px-4 py-2 rounded-lg"
                               required>
                    </div>
                @endif

                <!-- Mot de passe (si présent) -->
                @if($server->password)
                    <div class="mb-2">
                        <input type="password" 
                               name="password" 
                               placeholder="Mot de passe" 
                               class="w-full bg-gray-800 px-4 py-2 rounded-lg"
                               required>
                    </div>
                @endif

                <!-- Bouton Rejoindre -->
                <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded">
                    Rejoindre
                </button>
            </form>
        </div>
    @endforeach
</div>

        </section>
    </main>

    <!-- Scripts -->
    <script>
        // Gestion du menu mobile
        const mobileMenuButton = document.querySelector('.mobile-menu-button')
        const sidebar = document.querySelector('nav')
        
        mobileMenuButton.addEventListener('click', () => {
            sidebar.classList.toggle('mobile-hidden')
            sidebar.classList.toggle('left-0')
            sidebar.classList.toggle('-left-64')
        })

        // Gestion des tooltips
        document.querySelectorAll('[data-tooltip]').forEach(element => {
            element.addEventListener('mouseenter', () => {
                const tooltip = element.querySelector('span')
                const rect = element.getBoundingClientRect()
                tooltip.style.top = `${rect.top}px`
                tooltip.style.left = `${rect.right + 10}px`
            })
        })
    </script>
</body>
</html>
