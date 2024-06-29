@extends('layouts.app')

@section('content')

<section class="">
    <div class="container mt-3 mb-3 p-3 d-flex justify-content-center bg-light">
        <a class="btn btn-primary" href="{{ route('admin.companies.create')}}">Crea il tuo ristorante</a>
    </div>
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
                    <tr class="position-relative">
                        <td class="text-center">{{ $company->name }}</td>
                        <td class="text-center">{{ $company->address}}, {{ $company->city }}</td>
                        <td class="text-center">{{ $company->phone_number}}</td>
                        <td class="text-center">{{ $company->email}}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.companies.show', $company)}}" class="link link-success">Dettagli</a>
                        </td>
                        <td class="text-center"><a href="{{ route('admin.companies.edit', $company)}}"
                                class="link link-primary">Modifica</a></td>
                        <td class="text-center">
                            <form class="item-delete-form" action="{{ route('admin.companies.destroy', $company) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-link p-0 m-0 no-style text-danger"><i
                                        class="fas fa-trash-alt "></i></button>
                                <div class="my-modal">
                                    <div class="my-modal__box">
                                        <h4 class="text-center me-5">Vuoi eliminare questo ristorante?</h4>
                                        <span class="link link-danger my-modal-yes mx-5">Si</span>
                                        <span class="link link-success my-modal-no mx-5">No</span>

                                    </div>
                                </div>

                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</section>
@endsection