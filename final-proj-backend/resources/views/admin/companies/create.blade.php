@extends('layouts.app')

@section('content')
<div class="container bg-light mt-5 mb-5 rounded-4 p-5">
    <h1>Crea il tuo ristorante</h1>
    <form action="{{ route('admin.companies.store', $company)}}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label fb-bold">Nome</label>
            <input type="text" class="form-control" id="name" placeholder="Inserisci il nome" value="{{ old('name') }}">
        </div>
        <div class="mb-3">
         <label for="city" class="form-label fb-bold">Città</label>
         <input type="text" class="form-control" name="city" id="city" placeholder="Inserisci la città" value="{{ old('city') }}" >
        </div>
        <div class="mb-3">
            <label for="address" class="form-label fb-bold">Via</label>
            <input type="text" class="form-control" name="address" id="address" placeholder="Inserisci la via" value="{{ old('address') }}">
        </div>
        <div class="mb-3">
            <label for="vat_number" class="form-label fb-bold">P.iva</label>
            <input type="text" class="form-control" name="vat_number" id="vat_number" placeholder="Inserisci la p.iva" value="{{ old('vat_number') }}">
        </div>
        <div class="mb-3">
            <label for="phone_number" class="form-label fb-bold">Telefono</label>
            <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Inserisci il numero di telefono" value="{{ old('phone_number') }}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label fb-bold">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Inserisci la tua email" value="{{ old('email') }}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descrizione</label>
           <textarea class="form-control" name="description" id="description" placeholder="Inserisci la descrizione">{{ old('description') }}</textarea>
        </div>
        <div class="form-group mb-3">
            <label for="type_id">Tipologia</label>
            <select class="form-control" name="type_id" id="type_id">
                <option value="">--Seleziona la tua tipologia--</option>
                @foreach($types as $type)
                    <option @selected($type->id == old('type_id')) value="{{$type->id}}">{{$type->name}}</option>
                @endforeach
            </select>

        </div>
        <div class="mb-3">
            <label for="image" class="form-label fb-bold">Carica un'immagine</label>
            <input class="form-control" type="file" name="image" id="image">
        </div>
        <button class="btn btn-success">Crea</button>

    </form>
</div>
<div class="container mt-4">
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>

@endsection