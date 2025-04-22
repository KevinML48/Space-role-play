@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Créer un nouveau serveur</h1>
    <form action="{{ route('servers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="name" class="block mb-2">Nom du serveur</label>
            <input type="text" name="name" id="name" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label for="code" class="block mb-2">Code d'invitation (optionnel)</label>
            <input type="text" name="code" id="code" class="border p-2 w-full">
        </div>
        <div class="mb-4">
    <label for="short_description" class="block mb-2">Description courte (optionnelle)</label>
    <textarea name="short_description" id="short_description" class="border p-2 w-full"></textarea>
</div>
        <div class="mb-4">
            <label for="image" class="block mb-2">Logo du serveur (optionnel)</label>
            <input type="file" name="image" id="image" class="border p-2 w-full" accept="image/*">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Créer le serveur</button>
    </form>
</div>
@endsection
