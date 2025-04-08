<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $channel->name }} - Chat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Personnalisation de la scrollbar */
        .messages-container::-webkit-scrollbar {
            width: 8px;
        }
        
        .messages-container::-webkit-scrollbar-track {
            background: #1f2937;
        }
        
        .messages-container::-webkit-scrollbar-thumb {
            background: #374151;
            border-radius: 4px;
        }
        
        .messages-container::-webkit-scrollbar-thumb:hover {
            background: #4b5563;
        }
    </style>
</head>
<body class="bg-gray-950 text-gray-100">
    <!-- Barre latérale mobile -->
    <nav class="md:hidden fixed top-0 left-0 w-full bg-gray-900 p-4 z-10">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <button class="text-gray-400 hover:text-white" id="mobileMenuButton">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h1 class="text-xl font-bold">
                    <i class="fas fa-hashtag"></i>
                    {{ $channel->name }}
                </h1>
            </div>
            <a href="#" class="text-blue-500 hover:text-blue-400">
                <i class="fas fa-users"></i>
            </a>
        </div>
    </nav>

    <!-- Conteneur principal -->
    <div class="flex h-screen pt-16 md:pt-0">
        <!-- Barre latérale (version desktop) -->
        <aside class="hidden md:block w-64 bg-gray-900 p-4 border-r border-gray-800">
            <h2 class="text-lg font-bold mb-4 flex items-center gap-2">
                <i class="fas fa-hashtag"></i>
                {{ $channel->name }}
            </h2>
            
            <div class="space-y-4">
                <div class="bg-gray-800 p-3 rounded-lg">
                    <h3 class="text-sm font-semibold mb-2">Membres en ligne</h3>
                    <div class="space-y-2">
                        <!-- Exemple d'utilisateur -->
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-blue-500 rounded-full"></div>
                            <span class="text-sm">Utilisateur#1234</span>
                        </div>
                    </div>
                </div>
                
                <button class="w-full bg-gray-800 p-3 rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-cog"></i> Paramètres
                </button>
            </div>
        </aside>

        <!-- Zone de discussion -->
        <main class="flex-1 flex flex-col">
            <!-- En-tête -->
            <header class="bg-gray-900 p-4 border-b border-gray-800 hidden md:flex items-center justify-between">
                <h1 class="text-xl font-bold flex items-center gap-2">
                    <i class="fas fa-comments"></i>
                    {{ $channel->name }}
                </h1>
                
                <div class="flex items-center gap-4">
                    <button class="text-gray-400 hover:text-white">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="text-gray-400 hover:text-white">
                        <i class="fas fa-bell"></i>
                    </button>
                </div>
            </header>

            <!-- Messages -->
            <div class="messages-container flex-1 overflow-y-auto p-4 space-y-4">
                @foreach($messages as $message)
                    <div class="flex gap-3">
                        <!-- Avatar -->
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                            {{ strtoupper(substr($message->user->name, 0, 1)) }}
                        </div>
                        
                        <!-- Contenu du message -->
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-bold">{{ $message->user->name }}</span>
                                <span class="text-xs text-gray-400">
                                    {{ $message->created_at->format('d/m/Y H:i') }}
                                </span>
                            </div>
                            <p class="text-gray-300">{{ $message->content }}</p>
                            
                            <!-- Actions -->
                            <div class="flex gap-2 mt-2 opacity-0 hover:opacity-100 transition-opacity">
                                <button class="text-gray-400 hover:text-white">
                                    <i class="fas fa-reply"></i>
                                </button>
                                <button class="text-gray-400 hover:text-white">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Formulaire d'envoi -->
            <form action="{{ route('messages.store', $channel) }}" method="POST" class="bg-gray-900 p-4 border-t border-gray-800">
                @csrf
                <div class="flex items-center gap-2">
                    <button type="button" class="text-gray-400 hover:text-white p-2">
                        <i class="fas fa-plus"></i>
                    </button>
                    
                    <input type="text" 
                           name="content" 
                           placeholder="Écrire un message..." 
                           class="flex-1 bg-gray-800 rounded-full px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                           autocomplete="off">
                    
                    <button type="submit" 
                            class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600 transition-colors">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </main>
    </div>

    <!-- Scripts -->
    <script>
        // Gestion du menu mobile
        const mobileMenuButton = document.getElementById('mobileMenuButton')
        const sidebar = document.querySelector('aside')
        
        mobileMenuButton?.addEventListener('click', () => {
            sidebar.classList.toggle('hidden')
            sidebar.classList.toggle('absolute')
            sidebar.classList.toggle('md:hidden')
        })

        // Auto-scroll vers les nouveaux messages
        const messagesContainer = document.querySelector('.messages-container')
        messagesContainer.scrollTop = messagesContainer.scrollHeight

        // Focus automatique sur l'input
        const messageInput = document.querySelector('input[name="content"]')
        messageInput.focus()
    </script>
</body>
</html>
