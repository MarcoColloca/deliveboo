@extends('layouts.app')

@section('title', 'Dishes')

@section('content')

<section class="my-3 py-1">
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th class="text-center" scope="col">Nome piatto</th>
                    <th class="text-center" scope="col">Prezzo</th>
                    <th class="text-center" scope="col">Disponibile</th>
                    <th class="text-center" scope="col"></th>
                    <th class="text-center" scope="col"></th>
                    <th class="text-center" scope="col"></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($dishes as $dish)
                <tr>
                    <td class="text-center">{{ $dish->name }}</td>
                    <td class="text-center">{{ $dish->price}} €</td>
                    <td class="text-center">{{ $dish->visible === 1 ? 'Sì' : 'No'}}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.dishes.show', $dish)}}">Dettagli</a></td>
                    <td class="text-center">Modifica</td>
                    <td class="text-center">X</td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</section>

@endsection