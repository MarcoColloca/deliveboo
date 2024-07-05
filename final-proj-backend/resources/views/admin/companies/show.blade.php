@extends('layouts.app')

@section('title', $company->name)



@section('content')
<section class="my-3 py-1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card">
                    @if($company->image)
                        <img src="{{ asset('storage/' . $company->image) }}" alt="nessuna immagine" class="card-img-top">
                    @else
                    <img src="{{  asset('storage/image/default-company.jpg') }} " class="card-img-top" alt="...">      
                    @endif
                    <div class="card-body">
                        <h5>{{$company->name}}</h5>
                        <p>{{$company->description}}</p>
                    </div>
                    
                    <table class="table">
                        <tbody>
                            <tr class="border-top">
                                <td class="border-end"><strong>Città:</strong></td>
                                <td>{{$company->city}}</td>
                            </tr>
                            <tr>
                                <td class="border-end"><strong>Indirizzo:</strong></td>
                                <td>{{$company->address}}</td>
                            </tr>
                            <tr>
                                <td class="border-end"><strong>P.iva:</strong></td>
                                <td>{{$company->vat_number}}</td>
                            </tr>
                            <tr>
                                <td class="border-end"><strong>Tipo:</strong></td>
                                <td>
                                    @foreach($company->types as $type)
                                        {{$type->name}}
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td class="border-end"><strong>Telefono:</strong></td>
                                <td>{{$company->phone_number}}</td>
                            </tr>
                            <tr>
                                <td class="border-end"><strong>Email:</strong></td>
                                <td>{{$company->email}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="card-body d-flex justify-content-around position-relative">
                        <a href="{{ route('admin.companies.edit', $company)}}" class="link link-primary">Modifica</a>
                        <form class="item-delete-form" action="{{ route('admin.companies.destroy', $company) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-link p-0 m-0 no-style text-danger"><i class="fas fa-trash-alt "></i></button>
                            <div class="my-modal">
                                <div class="my-modal__box">
                                    <h4 class="text-center px-2 me-3">Vuoi eliminare questo Ristorante?</h4>
                                    <span class="link link-danger my-modal-yes mx-5">Si</span>
                                    <span class="link link-success my-modal-no mx-5">No</span>
        
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>










    </div>
</section>
@endsection