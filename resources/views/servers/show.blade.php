<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $server->name }} - Gestion des salons</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @media (max-width: 768px) {
            .mobile-menu-button {
                display: block !important;
            }
            
            .mobile-hidden {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-gray-950 text-gray-100">
    <!-- Menu mobile -->
    <button class="mobile-menu-button hidden fixed top-4 left-4 z-50 bg-gray-800 p-3 rounded-lg">
        <i class="fas fa-bars text-white"></i>
    </button>

    <!-- Barre latérale -->
    <nav class="mobile-hidden fixed left-0 top-0 h-screen w-64 bg-gray-900 flex flex-col py-4 space-y-4 z-40">
        <!-- Header du serveur -->
        <!-- Header du serveur -->
<div class="px-4">
    <div class="flex items-center gap-2">
        @if($server->image)
            <img src="{{ asset('storage/' . $server->image) }}" alt="Logo du serveur" class="w-8 h-8 rounded-lg object-cover">
        @else
            <div class="bg-blue-600 w-8 h-8 rounded-lg flex items-center justify-center">
                {{ substr($server->name, 0, 1) }}
            </div>
        @endif
        <h1 class="text-xl font-bold">{{ $server->name }}</h1>
    </div>
    <p class="text-sm text-gray-400 mt-2">Code d'invitation : {{ $server->code }}</p>

    @role('admin')
    <a href="{{ route('servers.edit', $server) }}" class="mt-2 block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-edit"></i> Modifier
    </a>
    @endrole
</div>


        <!-- Navigation -->
        <div class="flex-1 overflow-y-auto px-4">
            @foreach ($categories as $category)
                <div class="mb-4">
                    <h3 class="text-gray-400 font-semibold mb-2">{{ $category->name }}</h3>
                    <ul class="ml-4">
                        @foreach ($category->channels as $channel)
                            <li class="mb-2">
                                <a href="{{ route('channels.show', $channel) }}" 
                                   class="text-gray-300 hover:text-white flex items-center gap-2 transition-colors">
                                    <i class="fas fa-hashtag text-gray-500"></i>
                                    {{ $channel->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    
                    @role('admin')
                    <form action="{{ route('channels.store', $category) }}" method="POST" class="mt-2">
                        @csrf
                        <div class="flex gap-2">
                            <input type="text" 
                                   name="name" 
                                   placeholder="Nouveau salon" 
                                   class="bg-gray-800 text-sm p-2 rounded-lg flex-grow">
                            <button type="submit" 
                                    class="bg-green-600 px-3 rounded-lg hover:bg-green-500 transition-colors">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </form>
                    @endrole
                </div>
            @endforeach
        </div>

        <!-- Création de catégorie -->
        @role('admin')
        <div class="px-4">
            <form action="{{ route('categories.store', $server) }}" method="POST">
                @csrf
                <div class="flex gap-2">
                    <input type="text" 
                           name="name" 
                           placeholder="Nouvelle catégorie" 
                           class="bg-gray-800 text-sm p-2 rounded-lg flex-grow">
                    <button type="submit" 
                            class="bg-blue-600 px-3 rounded-lg hover:bg-blue-500 transition-colors">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </form>
        </div>
        @endrole
    </nav>

    <!-- Contenu principal -->
    <main class="ml-0 md:ml-64 p-4 md:p-6 transition-all duration-300">
        <!-- Header -->
        <header class="bg-gray-900 p-4 md:p-6 rounded-xl mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl md:text-2xl font-bold flex items-center gap-2">
                <i class="fas fa-hashtag"></i>
                {{ $server->name }}
            </h1>
        </div>
        @role('admin')
        <a href="{{ route('servers.edit', $server) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-edit"></i> Modifier
        </a>
        @endrole
    </div>
</header>


        <!-- Section des catégories -->
        <section class="space-y-6">
            @foreach ($categories as $category)
                <div class="bg-gray-900 p-4 rounded-xl">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold flex items-center gap-2">
                            <i class="fas fa-folder"></i>
                            {{ $category->name }}
                        </h2>
                        
                        @role('admin')
                        <form action="{{ route('channels.store', $category) }}" method="POST" class="hidden md:flex gap-2">
                            @csrf
                            <input type="text" 
                                   name="name" 
                                   placeholder="Nouveau salon" 
                                   class="bg-gray-800 text-sm p-2 rounded-lg w-48">
                            <button type="submit" 
                                    class="bg-green-600 px-4 rounded-lg hover:bg-green-500 transition-colors">
                                Ajouter
                            </button>
                        </form>
                        @endrole
                    </div>

                    <!-- Liste des salons -->
                    <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($category->channels as $channel)
                            <li class="bg-gray-800 p-4 rounded-lg hover:bg-gray-700 transition-colors">
                                <a href="{{ route('channels.show', $channel) }}" class="block">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-hashtag text-gray-500"></i>
                                        <span class="font-medium">{{ $channel->name }}</span>
                                    </div>
                                    <p class="text-sm text-gray-400 mt-2">Description du salon...</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </section>

        <!-- Création de catégorie (version desktop) -->
        @role('admin')
<div class="px-4">
    <form action="{{ route('categories.store', $server) }}" method="POST">
        @csrf
        <input type="hidden" name="server_id" value="{{ $server->id }}">  <!-- Ajout crucial -->
        <div class="flex gap-2">
            <input type="text"
                   name="name"
                   placeholder="Nouvelle catégorie"
                   class="bg-gray-800 text-sm p-2 rounded-lg flex-grow">
            <button type="submit"
                    class="bg-blue-600 px-3 rounded-lg hover:bg-blue-500 transition-colors">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </form>
</div>
@endrole
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
    </script>
</body>
</html>
