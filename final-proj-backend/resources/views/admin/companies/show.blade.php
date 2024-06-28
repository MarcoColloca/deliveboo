@extends('layouts.app')

@section('content')
<div class="container bg-light mt-5 mb-5 rounded-4 p-5">
    <h1>Il tuo ristorante</h1>
    <div class="row">
        <div class="col-6">
            <p><h4>Nome:</h4>{{$company->name}}</p>
            <p><h4>Città:</h4>{{$company->city}}</p>
            <p><h4>Indirizzo:</h4>{{$company->address}}</p>
            <p><h4>P.iva:</h4>{{$company->vat_number}}</p>
            <p><h4>Descrizione:</h4>{{$company->description}}</p>
           
            <p><h3>Tipo:</h3>
                 @foreach($company->types as $type)
                 {{$type->name}}
                 @endforeach
            </p>
        
        </div>
        <div class="col-6 d-flex flex-column justify-content-center">
            @if($company->image)
            <img src={{ $company->image }} alt="">
            @else
            <p>Non ci sono immagini del ristorante</p>
            @endif
            <p><h4>Telefono:</h4>{{$company->phone_number}}</p>
            <p><h4>Email:</h4>{{$company->email}}</p>
        </div>
    </div>
   









</div>
@endsection