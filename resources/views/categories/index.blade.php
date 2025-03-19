<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">{{ __("List of Categories") }}</h3>

                    <ul>
                        @foreach($categories as $category)
                            <li class="mb-2">{{ $category->name }}</li>
                        @endforeach
                    </ul>

                    <a href="{{ route('dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                        {{ __("Back to Dashboard") }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
