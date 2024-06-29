@extends('layouts.app')

@section('title', 'Dishes')

@section('content')

<section class="my-3 py-1">
    <div class="container">
        <div class="d-flex justify-content-center mx-4">
            <a class="btn btn-outline-light text-decoration-none" href="{{route('admin.dishes.create')}}">Aggiunti un piatto ad un Ristorante</a>
        </div>
    </div>
    <div class="container">
        <div class="row">            
            <div class="col-12">
                @foreach ($company_dishes as $company_name => $dishes)
                    <div class="d-flex justify-content-between mt-5 mb-1">                        
                        <h2 class=" text-light">{{$company_name}}</h2>                    
                    </div>
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
                @endforeach
            </div>
        </div>        
    </div>
</section>

@endsection