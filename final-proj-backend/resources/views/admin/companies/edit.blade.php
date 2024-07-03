@extends('layouts.app')

@section('title', 'Modifica Ristorante')

@section('content')
<div class="container bg-light mt-5 mb-5 rounded-4 p-5">
    <h1 class="text-center mb-3">Modifica le informazioni della tua compagnia</h1>
    @if($company->image)
    <img src="{{ asset('storage/'. $company->image) }}" alt="image{{$company->name}}">
    @else
    <img src="{{  asset('storage/image/default-company.jpg') }} " class="card-img-top w-50" alt="...">      
    @endif
 
    <form action="{{ route('admin.companies.update', $company)}}" method="POST"  enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <p class="text-danger">* campi obbligatori</p>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label fb-bold">Nome *</label>
            <input type="text" required name="name" class="form-control" id="name" placeholder="Inserisci il nome" value="{{ old('name', $company->name) }}">
        </div>
        <div class="mb-3">
         <label for="city" class="form-label fb-bold">Città *</label>
         <input type="text"required  class="form-control" name="city" id="city" placeholder="Inserisci la città" value="{{ old('city', $company->city) }}" >
        </div>
        <div class="mb-3">
            <label for="address" class="form-label fb-bold">Indirizzo *</label>
            <input type="text" required class="form-control" name="address" id="address" placeholder="Inserisci la via" value="{{ old('address', $company->address) }}">
        </div>
        <div class="mb-3">
            <label for="vat_number" class="form-label fb-bold">P.iva *</label>
            <input type="text" required class="form-control" name="vat_number" id="vat_number" placeholder="Inserisci la p.iva" value="{{ old('vat_number', $company->vat_number) }}">
        </div>
        <div class="mb-3">
            <label for="phone_number" class="form-label fb-bold">Telefono *</label>
            <input type="text" required  class="form-control" name="phone_number" id="phone_number" placeholder="Inserisci il numero di telefono" value="{{ old('phone_number', $company->phone_number) }}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label fb-bold">Email *</label>
            <input type="email" required class="form-control" name="email" id="email" placeholder="Inserisci la tua email" value="{{ old('email', $company->email) }}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descrizione</label>
           <textarea class="form-control" name="description" id="description" placeholder="Inserisci la descrizione">{{ old('description', $company->description) }}</textarea>
        </div>
        <div class="form-group mb-3">
            <label for="type_id">Tipologia *</label>
            <div class="mb-3">
                @foreach ($types as $type)
                    <div class="form-check">
                        <input @checked(in_array($type->id, old('types', $company->types->pluck('id')->all()))) type="checkbox" id="type-{{ $type->id }}"
                            value="{{ $type->id }}" name="types[]" class="form-check-input checkbox">
                        <label class="form-check-label" for="type-{{ $type->id }}">{{ $type->name }}</label>
                    </div>
                @endforeach
            </div>
            <div class="mb-3">
                <label for="image" class="form-label fb-bold">Cambia la tua immagine</label>
                <input class="form-control" type="file" name="image" id="image">
            </div>

        </div>
        <button class="btn btn-success">Modifica</button>
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