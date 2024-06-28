@extends('layouts.app')

@section('content')

<div class="text-white">
    <h1>INDEX</h1>

    <div class="container">
        <div class="row">
            <table>
                <thead>
                    <th>Name</th>
                    <th>Indirizzo</th>
                    <th>Numero di telefono</th>
                    <th>Email</th>
                </thead>
                @foreach ($companies as $company)
                    <tbody>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->address }}, {{ $company->city }}</td>
                        <td>{{ $company->phone_number }}</td>
                        <td>{{ $company->email }}</td>
                    </tbody>
                @endforeach
            </table>
        </div>

    </div>
    @endsection