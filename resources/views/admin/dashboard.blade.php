<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">{{ __("Welcome to the Admin Dashboard") }}</h3>
                    <p class="mb-4">{{ __("Here you can manage your site's settings and users.") }}</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="font-bold mb-2">{{ __("User Management") }}</h4>
                            <p>{{ __("Total Users:") }} {{ \App\Models\User::count() }}</p>
                            <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">{{ __("Manage Users") }}</a>
                        </div>

                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="font-bold mb-2">{{ __("Site Statistics") }}</h4>
                            <p>{{ __("Placeholder for site statistics") }}</p>
                            <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">{{ __("View Details") }}</a>
                        </div>
                    </div>

                    <!-- Section Gestion des Catégories -->
                    <div class="mt-6 bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                        <h4 class="font-bold mb-2">{{ __("Category Management") }}</h4>
                        <a href="{{ route('categories.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                            {{ __("View Categories") }}
                        </a>
                        <form method="POST" action="{{ route('categories.store') }}" class="mt-2">
                            @csrf
                            <input type="text" name="name" required placeholder="Category Name"
                                   class="px-2 py-1 bg-gray-800 border border-gray-700 rounded text-white">
                            <button type="submit" class="bg-green-500 px-4 py-2 rounded">
                                {{ __("Create Category") }}
                            </button>
                        </form>
                    </div>

                    <!-- Section Gestion des Salons -->
                    <div class="mt-6 bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                        <h4 class="font-bold mb-2">{{ __("Salon Management") }}</h4>
                        <a href="{{ route('salons.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                            {{ __("View Salons") }}
                        </a>
                        <form method="POST" action="{{ route('salons.store') }}" class="mt-2">
                            @csrf
                            <select name="category_id" required class="px-2 py-1 bg-gray-800 border border-gray-700 rounded text-white">
                                <option value="" disabled selected>{{ __("Select a category") }}</option>
                                @foreach(\App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="name" required placeholder="Salon Name"
                                   class="px-2 py-1 bg-gray-800 border border-gray-700 rounded text-white">
                            <button type="submit" class="bg-green-500 px-4 py-2 rounded">
                                {{ __("Create Salon") }}
                            </button>
                        </form>
                    </div>

                    <!-- Section Messages des Salons -->
<!-- Section d'envoi de message -->
<div class="mt-6 bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
    <h4 class="font-bold mb-2">{{ __("Send a Message") }}</h4>

    <form method="POST" action="{{ route('messages.store') }}">
        @csrf
        <!-- Sélection du salon -->
        <select name="salon_id" required class="px-2 py-1 bg-gray-800 border border-gray-700 rounded text-white">
            <option value="" disabled selected>{{ __("Choose a salon") }}</option>
            @foreach($salons as $salon)
                <option value="{{ $salon->id }}">{{ $salon->name }}</option>
            @endforeach
        </select>

        <!-- Zone de texte pour le message -->
        <textarea name="content" required placeholder="Type your message here..." 
                  class="px-2 py-1 bg-gray-800 border border-gray-700 rounded text-white w-full mt-2"></textarea>

        <button type="submit" class="bg-green-500 px-4 py-2 rounded mt-2">
            {{ __("Send Message") }}
        </button>
    </form>
</div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
