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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
