<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Salons') }}
        </h2>
    </x-slot>

    <div class="flex h-screen">
        <!-- Liste des salons (Sidebar) -->
        <div class="w-1/4 bg-gray-900 text-white p-4">
            <h3 class="text-lg font-bold mb-4">Salons</h3>
            <ul>
                @foreach($salons as $salon)
                    <li class="mb-2">
                        <a href="{{ route('salons.show', $salon->id) }}" class="block p-2 bg-gray-800 rounded hover:bg-gray-700">
                            {{ $salon->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Section Messages -->
        <div class="w-3/4 bg-gray-100 dark:bg-gray-800 p-6 flex flex-col justify-between">
            @if(isset($currentSalon))
                <div>
                    <h3 class="text-lg font-bold">{{ $currentSalon->name }}</h3>
                    <div class="h-[500px] overflow-y-auto bg-gray-700 p-4 rounded">
                        @foreach($currentSalon->messages as $message)
                            <div class="p-2 border-b border-gray-600 text-white">
                                <strong>{{ $message->user->name }}:</strong> {{ $message->content }}
                                <small class="block text-gray-500">{{ $message->created_at->diffForHumans() }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Formulaire d'envoi de message -->
                <form method="POST" action="{{ route('messages.store') }}" class="mt-4">
                    @csrf
                    <input type="hidden" name="salon_id" value="{{ $currentSalon->id }}">
                    <div class="flex">
                        <input type="text" name="content" required placeholder="Écrire un message..."
                            class="flex-1 p-2 rounded bg-gray-800 border border-gray-700 text-white">
                        <button type="submit" class="ml-2 bg-blue-500 px-4 py-2 rounded">
                            Envoyer
                        </button>
                    </div>
                </form>
            @else
                <p class="text-gray-500">Sélectionnez un salon pour voir les messages.</p>
            @endif
        </div>
    </div>
</x-app-layout>
