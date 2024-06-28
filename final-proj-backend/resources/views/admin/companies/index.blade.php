@extends('layouts.app')

@section('content')

<section class="my-3 py-1">
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th class="text-center" scope="col">Nome</th>
                    <th class="text-center" scope="col">Indirizzo</th>
                    <th class="text-center" scope="col">Numero di telefono </th>
                    <th class="text-center" scope="col">Email</th>
                    <th class="text-center" scope="col"></th>
                    <th class="text-center" scope="col"></th>
                    <th class="text-center" scope="col"></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($companies as $company)
                <tr>
                    <td class="text-center">{{ $company->name }}</td>
                    <td class="text-center">{{ $company->address}}, {{ $company->city }}</td>
                    <td class="text-center">{{ $company->phone_number}}</td>
                    <td class="text-center">{{ $company->email}}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.dishes.show', $company)}}">Dettagli</a></td>
                    <td class="text-center">Modifica</td>
                    <td class="text-center">X</td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</section>
    @endsection