@extends('layouts.app')

@section('title', 'Ordini per ' . $company->name)

@section('content')
<section class="my-3 py-1">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-end mt-5 mb-1">
                    <h3 class="text-light">
                        <p class="text-blue">
                            {{ $company->name }}
                            <span class="fs-6 ms-3">{{ $company->address }}</span>
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
                                <th class="text-center" scope="col">Data Ordine</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($orders as $order)
                                <tr class="position-relative">
                                    <td class="text-start fw-lighter">{{ $order->customer_name }}</td>
                                    <td class="text-start fw-lighter">{{ $order->customer_address }}</td>
                                    <td class="text-start fw-lighter">{{ $order->customer_mail ?? 'nessuna mail'}}</td>
                                    <td class="text-start fw-lighter">{{ $order->customer_phone}}</td>
                                    <td class="text-center fw-lighter">{{ $order->total}}  €</td>
                                    <td class="text-center fw-lighter">{{ formatItalianDate($order->created_at)}}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="link link-success">Dettagli</a>
                                    </td>
                                </tr>
                            @empty
                                <td colspan="6" class="text-center fw-lighter">Nessun ordine per questa compagnia.</td>
                            @endforelse
                           
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</section>
@endsection
