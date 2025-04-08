@extends('layouts.app')

@section('title', 'Salon : ' . $salon->name)

@section('header', "Salon : $salon->name")

@section('content')
    <div class="border border-gray-700 p-4 rounded">
        @foreach ($salon->messages as $message)
            <div class="mb-2">
                <strong>{{ $message->user->name }}</strong> :
                <p class="bg-gray-800 p-2 rounded">{{ $message->content }}</p>
            </div>
        @endforeach
    </div>

    @include('messages.form', ['salon' => $salon])

    <a href="/categories/{{ $salon->category_id }}/salons" class="text-yellow-500">⬅ Retour aux salons</a>
@endsection
