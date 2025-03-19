<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Salons') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">{{ __("Select a Salon") }}</h3>

                    <!-- Formulaire de sélection du salon -->
                    <form method="GET" action="{{ route('salons.index') }}">
                        <select name="salon_id" onchange="this.form.submit()" class="px-2 py-1 bg-gray-800 border border-gray-700 rounded text-white">
                            <option value="">{{ __("Choose a Salon") }}</option>
                            @foreach($salons as $salon)
                                <option value="{{ $salon->id }}" {{ request('salon_id') == $salon->id ? 'selected' : '' }}>
                                    {{ $salon->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    @if(request('salon_id'))
                        @php $selectedSalon = \App\Models\Salon::find(request('salon_id')); @endphp
                        @if($selectedSalon)
                            <div class="mt-6">
                                <h4 class="font-bold">{{ $selectedSalon->name }}</h4>

                                @if($selectedSalon->messages->count())
                                    @foreach($selectedSalon->messages as $message)
                                        <div class="p-2 border-b border-gray-600">
                                            <strong>{{ $message->user->name }}:</strong> {{ $message->content }}
                                            <small class="block text-gray-500">{{ $message->created_at->diffForHumans() }}</small>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-gray-500">{{ __("No messages yet.") }}</p>
                                @endif
                            </div>
                        @endif
                    @endif

                    <a href="{{ route('dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                        {{ __("Back to Dashboard") }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div>
        {{ $salons->links() }}
    </div>
</x-app-layout>
