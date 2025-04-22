@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Modifier le serveur : {{ $server->name }}</h1>

    @role('admin')
    <form action="{{ route('servers.update', $server) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block mb-2">Nom du serveur</label>
            <input type="text" name="name" id="name" class="border p-2 w-full" value="{{ $server->name }}" required>
        </div>
        <div class="mb-4">
            <label for="code" class="block mb-2">Code d'invitation (optionnel)</label>
            <input type="text" name="code" id="code" class="border p-2 w-full" value="{{ $server->code }}">
        </div>
            <textarea name="short_description" id="short_description" class="border p-2 w-full">{{ $server->short_description }}</textarea>
         <div class="mb-4">
            <label for="image" class="block mb-2">Logo du serveur (optionnel)</label>
            <input type="file" name="image" id="image" class="border p-2 w-full" accept="image/*">
            @if($server->image)
                <img src="{{ asset('storage/' . $server->image) }}" alt="Logo actuel" style="max-width: 100px; margin-top: 10px;">
            @endif
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Mettre à jour le serveur</button>
    </form>
    @else
        <p>Vous n'avez pas les droits pour modifier ce serveur.</p>
    @endrole
</div>
@endsection
