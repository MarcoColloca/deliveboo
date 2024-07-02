@extends('layouts.app')

@section('title', 'Home')



@section('content')

    <div class="jumbotron p-5 m-5 bg-light rounded-3">
        <div class="container py-5">
            <div class="">
                <img src="{{Vite::asset('resources/img/logo-placeholder.png')}}" alt="">
            </div>
            <h1 class="display-5 fw-bold">
                Benvenuto in Fooder! <i class="bi bi-cake"></i>
            </h1>

            <p class="col-md-8 fs-4">
                Questa è una intro al sito, che ancora non dice nulla, ma presto verrà implementata.
            </p>
        </div>
    </div>

@endsection