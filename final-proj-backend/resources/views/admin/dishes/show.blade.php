@extends('layouts.app')

@section('title', $dish->name)

@section('content')
<section class="my-3 py-1">
    <div class="container">
        <div class="card">
            <img src="{{ $dish->image}}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{ $dish->name }}</h5>
                <p class="card-text">{{ $dish->description }}</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Ingridienti: {{ $dish->ingredients }}</li>
                <li class="list-group-item">Prezzo: {{ $dish->price }} €</li>
                <li class="list-group-item">Disponibile: {{ $dish->visible === 1 ? 'Sì' : 'No' }}</li>
            </ul>
            <div class="card-body">
                <a href="#" class="card-link">Modifica</a>
                <a href="#" class="card-link">X</a>
            </div>
        </div>
    </div>
</section>
@endsection