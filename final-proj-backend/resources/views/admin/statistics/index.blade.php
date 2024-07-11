@extends('layouts.app')

@section('title', 'Statistiche dei tuoi ordini')

@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <h1 class="text-blue">Fatturato</h1>
                <p class="text-blue">Fatturato totale nell'ultimo anno dei tuoi ristoranti</p>
                <div class="card mt-3">
                    <div class="card-body">
                        <canvas id="pieChartRevenue" height="400"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <h1 class="text-blue">Ordini</h1>
                <p class="text-blue">Ordini totali nell'ultimo anno dei tuoi ristoranti</p>
                <div class="card mt-3">
                    <div class="card-body">
                        <canvas id="pieChartOrder" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5 mb-5">
        <x-filters :companies="$companies" />
        <div class="card mt-3">
            <div class="card-body">
                <canvas id="barChart" height="400"></canvas>
            </div>
        </div>
    </div>


    <script src="{{ asset('js/barChart.js') }}"></script>
    <script src="{{ asset('js/functionReady.js') }}"></script>
    <script src="{{ asset('js/randomColor.js') }}"></script>
    <script src="{{ asset('js/totalOrders.js') }}"></script>
    <script src="{{ asset('js/totalRevenue.js') }}"></script>

</section>

@endsection