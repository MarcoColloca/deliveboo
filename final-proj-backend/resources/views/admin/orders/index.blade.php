@extends('layouts.app')

@section('title', 'I Tuoi Ordini')

@section('content')
@php
    $companies_dict = $companies->keyBy('name');
@endphp
<section class="my-3 py-1">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @foreach ($companyOrders as $company_name => $orders)
                <div class="d-flex justify-content-between align-items-end mt-5 mb-1">
                    <h3 class="text-light">
                        <p class="text-blue">
                            <p>
                                {{ $company_name }}
                            </p>
                            
                        </p>
                    </h3>
                </div>
                
                <table class="table">
                    <thead>
                            <tr>
                                <th scope="col">Nome Cliente</th>
                                <th class="text-start" scope="col">Indirizzo</th>
                                <th class="text-start" scope="col">Email</th>
                                <th class="text-start" scope="col">Telefono</th>
                                <th class="text-center" scope="col">Totale Ordine</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($orders as $order)
                                <tr class="position-relative">
                                    <td class="text-start fw-lighter">{{ $order->customer_name }}</td>
                                    <td class="text-start fw-lighter">{{ $order->customer_address }}</td>
                                    <td class="text-start fw-lighter">{{ $order->customer_mail ?? 'nessuna mail'}}</td>
                                    <td class="text-start fw-lighter">{{ $order->customer_phone}}</td>
                                    <td class="text-center fw-lighter">{{ $order->total}}  €</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="link link-success">Dettagli</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
