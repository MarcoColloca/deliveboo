@extends('layouts.app')
@section('title', 'Dashboard')


@section('content')
<div class="container">
    <h2 class="fs-4 text-secondary my-4">    
        Benvenuto {{$user_name}}
    </h2>

    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header"> 
                    <h5>
                        Lista Ristoranti 
                    </h5>
                </div>

                <div class="card-body">
                    
                        <div class="row g-5 py-5 row-cols-1 row-cols-md-2 row-cols-lg-3 justify-content-center">
                            @foreach ($companies as $company)
                                <div class="col d-flex card-group justify-content-center">
                                    <div class="card w-75">
                                        <div class="card-header" style="height:200px">
                                            @if($company->image)
                                            <img src="{{ asset('storage/' . $company->image) }}" alt="nessuna immagine" class="card-img-top h-100 object-fit-cover">
                                            @else
                                            <img src="{{  asset('storage/image/default-company.jpg') }} " class="card-img-top h-100 object-fit-cover" alt="...">      
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <a href="{{route('admin.dishes.showOne', $company->id)}}">
                                                    {{$company->name}}
                                                </a>
                                            </h5>
                                            <p>
                                                {{$company->address}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
