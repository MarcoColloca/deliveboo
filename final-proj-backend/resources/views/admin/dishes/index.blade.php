@extends('layouts.app')

@section('title', 'Dishes')

@section('content')

@php
    $companies_dict = $companies->keyBy('name');
@endphp

<section class="my-3 py-1">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @foreach ($company_dishes as $company_name => $dishes)
                    <div class="d-flex justify-content-between mt-5 mb-1">
                        <h2 class="text-light">
                            <a href="{{route('admin.dishes.showOne', $companies_dict[$company_name]->id)}}">
                                {{ $company_name }}
                            </a>
                            {{$companies_dict[$company_name]->address}}
                        </h2>
                        @if(isset($companies_dict[$company_name]))
                            <a class="btn btn-outline-light text-decoration-none d-flex align-items-center"
                                href="{{ route('admin.dishes.create', ['company_id' => $companies_dict[$company_name]->id]) }}">
                                <i class="fas fa-plus pe-1 ps-1"></i>
                            </a>
                        @endif
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">Nome piatto</th>
                                <th class="text-center" scope="col">Prezzo</th>
                                <th class="text-center" scope="col">Disponibile</th>
                                <th class="text-center" scope="col"></th>
                                <th class="text-center" scope="col"></th>
                                <th class="text-center" scope="col"></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($dishes as $dish)
                                <tr class="position-relative">
                                    <td class="text-center">{{ $dish->name }}</td>
                                    <td class="text-center">{{ $dish->price}} €</td>
                                    <td class="text-center">{{ $dish->visible === 1 ? 'Sì' : 'No'}}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.dishes.show', $dish)}}" class="link link-success">Dettagli</a>
                                    </td>
                                    <td class="text-center"><a href="{{route('admin.dishes.edit', $dish)}}"
                                            class="link link-primary">Modifica</a></td>
                                    <td class="text-center">
                                        <form class="item-delete-form" action="{{ route('admin.dishes.destroy', $dish) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-link p-0 m-0 no-style text-danger"><i
                                                    class="fas fa-trash-alt "></i></button>
                                            <div class="my-modal">
                                                <div class="my-modal__box">
                                                    <h4 class="text-center me-5">Vuoi eliminare questo piatto?</h4>
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
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection