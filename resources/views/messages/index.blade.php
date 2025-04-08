<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Messages in ') . $salon->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">{{ __("Messages") }}</h3>

                    <div class="mb-6">
                        @foreach($messages as $message)
                            <div class="p-4 bg-gray-200 dark:bg-gray-700 rounded-lg mb-2">
                                <strong>{{ $message->user->name }}:</strong> {{ $message->content }}
                                <small class="block text-gray-500">{{ $message->created_at->diffForHumans() }}</small>
                            </div>
                        @endforeach
                    </div>

                    @auth
                        <form method="POST" action="{{ route('messages.store', $salon) }}">
                            @csrf
                            <textarea name="content" class="w-full p-2 border rounded" rows="3" placeholder="Type a message..." required></textarea>
                            <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded">
                                Send
                            </button>
                        </form>
                    @else
                        <p class="text-red-500">You must be logged in to send messages.</p>
                    @endauth

                    <a href="{{ route('dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                        {{ __("Back to Dashboard") }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
