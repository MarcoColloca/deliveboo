@extends('layouts.app')

@section('content')
<div class="container bg-light mt-5">
    <h1>Il tuo ristorante</h1>
    <div class="row">
        <div class="col-8">
            <p><h3>Nome:</h3>{{$company->name}}</p>
            <p><h3>Città:</h3>{{$company->city}}</p>
            <p><h3>Indirizzo:</h3>{{$company->address}}</p>
            <p><h3>P.iva:</h3>{{$company->vat_number}}</p>
            <p><h3>Descrizione:</h3>{{$company->description}}</p>
            <p><h3>Telefono:</h3>{{$company->phone_number}}</p>
            <p><h3>Email:</h3>{{$company->email}}</p>
            <p><h3>Tipo:</h3>
                 @foreach($company->types as $type)
                 {{$type->name}}
                 @endforeach
            </p>
        
        </div>
        <div class="col-4">

            <img src={{ $company->image }} alt="">
        </div>
    </div>
   









</div>
@endsection