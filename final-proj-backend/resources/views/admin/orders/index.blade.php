@extends('layouts.app')

@section('title', 'I Tuoi Ordini')

@section('content')
@php
    $companies_dict = $companies->keyBy('name');
@endphp

<section class="my-3 py-1">
    <div class="container container-transparent p-4 rounded-4">
       
            <h2 class="text-blue text-center fs-2 bg-light rounded-3 p-2 shadow mt-3">
                Tutti i Tuoi Ordini
            </h2>
            <div class="container">
                @foreach ($companies as $company)
                    @php
                        $ordersGroups = $companyOrders[$company->name] ?? collect();
                        $currentOrders = $ordersGroups[$currentChunkIndex] ?? collect();
                    @endphp
                    <div class="d-flex justify-content-between align-items-end mt-5 mb-1">
                        <h3 class="text-blue fs-2 bg-light rounded-3 p-2 shadow mt-3">
                            <p>
                                {{ $company->address }}
                            </p>
                            <p>
                                {{ $company->name }}
                            </p>
                        </h3>
                    </div>
                    
                    <table class="table w-100 d-block d-md-table scroll-table">
                        <thead>
                            <tr>
                                <th scope="col">Nome Cliente</th>
                                <th class="text-start" scope="col">Indirizzo</th>
                                <th class="text-start" scope="col">Email</th>
                                <th class="text-start" scope="col">Telefono</th>
                                <th class="text-center" scope="col">Totale Ordine</th>
                                <th class="text-center" scope="col">Data Ordine</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($currentOrders->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center">Nessun ordine per questa compagnia.</td>
                                </tr>
                            @else
                                @foreach ($currentOrders as $order)
                                    <tr class="position-relative">
                                        <td class="text-start fw-lighter">{{ $order->customer_name }}</td>
                                        <td class="text-start fw-lighter">{{ $order->customer_address }}</td>
                                        <td class="text-start fw-lighter">{{ $order->customer_email ?? 'nessuna mail'}}</td>
                                        <td class="text-start fw-lighter">{{ $order->customer_phone}}</td>
                                        <td class="text-center fw-lighter">{{ $order->total}} €</td>
                                        <td class="text-center fw-lighter">{{ formatItalianDate($order->created_at) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="link link-success"><i class="fa-regular fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    @if($ordersGroups->count() > 0)
                        <div class="d-flex justify-content-between">
                            @if ($currentChunkIndex > 0)
                                <a href="{{ request()->fullUrlWithQuery(['chunk' => $currentChunkIndex - 1]) }}" class="btn btn-link text-white">Indietro</a>
                            @else
                                <span></span>
                            @endif

                            @if ($currentChunkIndex < $ordersGroups->count() - 1)
                                <a href="{{ request()->fullUrlWithQuery(['chunk' => $currentChunkIndex + 1]) }}" class="btn btn-link text-white">Avanti</a>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        
    </div>
</section>
@endsection
