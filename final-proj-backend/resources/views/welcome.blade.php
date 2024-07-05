@extends('layouts.app')

@section('title', 'Home')



@section('content')

    <div class="jumbotron p-5 m-5 bg-light rounded-3 shadow">
        <div class="container py-5">
            <div class="row justify-content-around gap-2">
                <div class="col-10 col-md-6">
                    <img src="{{Vite::asset('resources/img/logo.png')}}" alt="">
                </div>
                <div class="col-10 col-md-4">
                    <h1 class="display-5 fw-bold text-blue">
                        Benvenuto in Fooder! <i class="bi bi-cake"></i>
                    </h1>
        
                    <p class="fs-4 mt-4 text-blue text-center">
                        Questa è una intro al sito, che ancora non dice nulla, ma presto verrà implementata.
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection