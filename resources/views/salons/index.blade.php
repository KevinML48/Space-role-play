<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Salons') }}
        </h2>
    </x-slot>

    <div class="flex h-screen">
        <!-- Liste des catégories et salons -->
        <div class="w-1/4 bg-gray-900 text-white p-4">
            <h3 class="text-lg font-bold mb-4">Catégories</h3>
            
            <!-- Formulaire de création -->
            <form action="{{ route('salons.store') }}" method="POST" class="mb-6">
                @csrf
                <div class="space-y-4">
                    <input type="text" name="name" required placeholder="Nom du salon"
                           class="w-full p-2 rounded bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <select name="category_id" required class="w-full p-2 rounded bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($categories as $category)
                            @if($category->server) <!-- Vérification de sécurité -->
                                <option value="{{ $category->id }}">
                                    {{ $category->name }} (Serveur: {{ $category->server->name }})
                                </option>
                            @else
                                <option value="{{ $category->id }}" class="text-red-500">
                                    {{ $category->name }} (Serveur non défini)
                                </option>
                            @endif
                        @endforeach
                    </select>

                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                        Créer le salon
                    </button>
                </div>
            </form>

            <!-- Liste -->
            <ul>
                @foreach($categories as $category)
                    <li class="mb-4">
                        <button class="w-full text-left p-2 bg-gray-800 rounded hover:bg-gray-700 transition duration-200 flex justify-between items-center"
                                onclick="toggleCategory({{ $category->id }})">
                            <span>{{ $category->name }}</span>
                            <svg class="w-4 h-4 transform transition-transform" id="arrow-{{ $category->id }}" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>

                        <ul id="category-{{ $category->id }}" class="ml-4 mt-2 space-y-2 hidden">
                            @foreach($category->salons as $salon)
                                <li>
                                    <a href="{{ route('salons.show', $salon->id) }}" 
                                       class="block p-2 bg-gray-800 rounded hover:bg-gray-700 transition duration-200 {{ isset($currentSalon) && $currentSalon->id === $salon->id ? 'ring-2 ring-blue-500' : '' }}">
                                        {{ $salon->name }}
                                        <span class="text-gray-400 text-sm block">{{ $salon->messages->count() }} messages</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Section Messages -->
        <div class="w-3/4 bg-gray-100 dark:bg-gray-800 p-6 flex flex-col justify-between">
            @if(isset($currentSalon))
                <div class="space-y-6">
                    <!-- En-tête du salon -->
                    <div class="flex justify-between items-center">
                        <h3 class="text-2xl font-bold text-white">{{ $currentSalon->name }}</h3>
                        <span class="text-gray-400">Créé le {{ $currentSalon->created_at->format('d/m/Y') }}</span>
                    </div>

                    <!-- Messages -->
                    <div class="h-[600px] overflow-y-auto pr-4">
                        @foreach($currentSalon->messages as $message)
                            <div class="p-4 mb-4 bg-gray-700 rounded-lg shadow-md">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 bg-blue-500 rounded-full flex items-center justify-center">
                                            {{ strtoupper(substr($message->user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-center">
                                            <span class="font-bold text-white">{{ $message->user->name }}</span>
                                            <span class="text-sm text-gray-400">{{ $message->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="mt-2 text-white">{{ $message->content }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Formulaire d'envoi de message -->
                <form method="POST" action="{{ route('messages.store') }}" class="mt-6">
                    @csrf
                    <input type="hidden" name="salon_id" value="{{ $currentSalon->id }}">
                    <div class="flex items-center space-x-4">
                        <input type="text" name="content" required placeholder="Écrire un message..."
                               class="flex-1 p-3 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                        <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition duration-200">
                            Envoyer
                        </button>
                    </div>
                </form>
            @else
                <div class="h-full flex items-center justify-center">
                    <p class="text-gray-400 text-xl">Sélectionnez un salon pour commencer à discuter</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        function toggleCategory(categoryId) {
            const categoryElement = document.getElementById(`category-${categoryId}`);
            const arrowElement = document.getElementById(`arrow-${categoryId}`);
            
            categoryElement.classList.toggle('hidden');
            arrowElement.classList.toggle('rotate-180');
        }

        // Ouvrir automatiquement la catégorie active
        @if(isset($currentSalon))
            document.addEventListener('DOMContentLoaded', () => {
                const categoryId = {{ $currentSalon->category_id }};
                toggleCategory(categoryId);
            });
        @endif
    </script>
</x-app-layout>
