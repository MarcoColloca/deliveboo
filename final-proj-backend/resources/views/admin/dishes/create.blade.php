@extends('layouts.app')

@section('content')
<div class="container bg-light mt-5 mb-5 rounded-4 p-5">
    <h1>Crea il tuo ristorante</h1>
    <form action="{{ route('admin.dishes.store')}}" method="POST"  enctype="multipart/form-data">
        @csrf


        <!-- Nome Piatto -->
        <div class="mb-3">
            <label for="name" class="form-label fb-bold">Nome</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Inserisci il nome" value="{{ old('name') }}">
        </div>

 
        <!-- Prezzo Piatto -->
        <div class="mb-3">
         <label for="price" class="form-label fb-bold">Prezzo</label>
         <input type="number" class="form-control" name="price" id="price" step=".01" placeholder="Inserisci il Prezzo" value="{{ old('price') }}" >
        </div>


        <!-- Visibilità Piatto -->
        <div class="mb-3">
            <label for="visible" class="form-label fb-bold">Visibilità nel Menù</label>
            <select class="form-control" name="visible" id="visible">
                <option value="">-- Seleziona Visibilità Piatto --</option>
                @foreach ($visibility as $visible => $value)                        
                    <option @selected($value == old('value')) value="{{$value}}">{{$visible}}</option>
                @endforeach
            </select>
        </div>


        <!-- Ingredienti Piatto -->
        <div class="mb-3">
            <label for="ingredients" class="form-label">Ingredienti</label>
           <textarea class="form-control" name="ingredients" id="ingredients" placeholder="Inserisci gli ingredienti">{{ old('ingredients') }}</textarea>
        </div>


        <!-- Descrizione Piatto -->
        <div class="mb-3">
            <label for="description" class="form-label">Descrizione</label>
           <textarea class="form-control" name="description" id="description" placeholder="Inserisci la descrizione">{{ old('description') }}</textarea>
        </div>


        <!-- Selezione Ristorante -->
        <div class="form-group mb-3">
            <label class="form-label fw-bold" for="company_id">Ristorante</label>
            <select class="form-control" name="company_id" id="company_id">
                <option value="">-- Seleziona Ristorante --</option>
                @foreach ($companies as $company)                        
                    <option @selected($company->id == old('company_id')) value="{{$company->id}}">{{$company->name}}</option>
                @endforeach
            </select>
        </div>


        <!-- Immagine Piatto -->
        <div class="mb-3">
            <label for="image" class="form-label fb-bold">Carica un'immagine</label>
            <input class="form-control" type="file" name="image" id="image">
        </div>


        <!-- Bottone di Invo Form -->
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