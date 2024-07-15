@extends('layouts.app')

@section('title', 'Statistiche dei tuoi ordini')

@section('content')
<section>
    <div class="container-transparent w-75 m-auto p-2 shadow rounded-3">
    <div class="container text-blue text-center fs-2 bg-light rounded-3 p-2 shadow mt-3">
        <div class="row row-cols-1 row-cols-md-2 ">
        <div class="col-12 mb-3">
            <select id="timePeriod" class="form-select">
                <option value="1">Ultimo mese</option>
                <option value="3">Ultimi 3 mesi</option>
                <option value="6">Ultimi 6 mesi</option>
                <option value="12" selected>Ultimo anno</option>
                <option value="9999">Tutti gli anni</option>
            </select>
        </div>
            <div class="col">
                <h1 class="text-blue">Fatturato</h1>
                <p class="text-blue">Fatturato totale nell'ultimo anno dei tuoi ristoranti</p>
                <div class="card mt-3">
                    <div class="card-body">
                        <canvas id="pieChartRevenue" height="400"></canvas>
                    </div>
                </div>
            </div>
            <div class="col">
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

    <div class="container text-blue text-center fs-2 bg-light rounded-3 p-2 shadow mt-5 mb-5">
        <x-filters :companies="$companies" />
        <div class="card mt-3">
            <div class="card-body">
                <canvas id="barChart" height="400"></canvas>
            </div>
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