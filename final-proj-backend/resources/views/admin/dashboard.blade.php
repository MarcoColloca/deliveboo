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
                    
                        <div class="row gap-5 justify-content-center">
                            @foreach ($companies as $company)
                                <div class="col-3">
                                    <div class="card">
                                        <div class="card-header">
                                            @if($company->image)
                                            <img src="{{ asset('storage/' . $company->image) }}" alt="nessuna immagine" class="card-img-top">
                                            @else
                                            <img src="{{  asset('storage/image/default-company.jpg') }} " class="card-img-top" alt="...">      
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
