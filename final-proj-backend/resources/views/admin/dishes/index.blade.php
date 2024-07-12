@extends('layouts.app')

@section('title', 'I tuoi Menu')

@section('content')

@php
    $companies_dict = $companies->keyBy('name');
@endphp

<section class="my-3 py-1">
    <div class="container container-transparent p-4 rounded-4">
        <div class="row">
            @unless (request('trash')) 
            <div  class="d-flex flex-column align-items-center justify-content-center">

                <h2 class="text-center text-blue fs-2 my-3">I tuoi Menu</h2> 
              <button class="btn btn-danger">

                  <a href="{{ route('admin.dishes.index', ['trash' => 1])}}" class="-link-color-white">
                    Vai al tuo cestino <i class="fas fa-trash-alt "></i>
                  </a>
              
              </button>
            </div>
            @elseif (request('trash'))
            <div  class="d-flex flex-column align-items-center justify-content-center">
            <h3 class="text-center text-white mt-3">Il tuo Cestino</h3>
            <button class="btn btn-danger">

                <a href="{{ route('admin.dishes.index')}}" class="-link-color-white">Indietro</a>
                              
            </button>
            </div> 
            @endif
            <div class="col-12">
                @foreach ($company_dishes as $company_name => $dishes)
                    <div class="d-flex justify-content-between align-items-end mt-5 mb-1">
                        <h3 class="text-light">
                            <p class="text-blue">
                                <a
                                    href="{{route('admin.dishes.showOne', ['dish' => $companies_dict[$company_name]->id])}}">{{ $company_name }}
                                </a>
                                <span class="fs-6 ms-3">{{$companies_dict[$company_name]->address}}</span>
                            </p>

                        </h3>
                        @unless (request('trash'))
                            @if(isset($companies_dict[$company_name]))
                            <a class="btn btn-outline-light text-decoration-none d-flex align-items-center h-75 px-2"
                            href="{{ route('admin.dishes.create', ['company_id' => $companies_dict[$company_name]->id]) }}">
                            <i class="fas fa-plus"></i>
                        </a>
                            @endif
                        @endunless
                    </div>
                    <table class="table overflow-auto">
                        <thead>
                            <tr>
                                <th scope="col">Nome piatto</th>
                                <th class="text-center" scope="col">Prezzo</th>
                                <th class="text-center" scope="col">Disponibile</th>
                                @unless(request('trash'))
                                    <th class="text-center" scope="col"></th>
                                @endunless                               
                                <th class="text-center" scope="col"></th>
                                <th class="text-center" scope="col"></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($dishes as $dish)
                                <tr class="position-relative">
                                    <td>{{ $dish->name }}</td>
                                    <td class="text-center ">{{ $dish->price}} €</td>
                                    <td class="text-center ">{{ $dish->visible === 1 ? 'Sì' : 'No'}}</td>
                                    @unless($dish->trashed())
                                        <td class="text-center ">
                                            <a href="{{ route('admin.dishes.show', $dish)}}" class="link link-success"><i class="fa-regular fa-eye"></i></a>
                                        </td>
                                        <td class="text-center"><a href="{{route('admin.dishes.edit', $dish)}}"
                                                class="link link-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                        </td>
                                    @elseif ($dish->trashed())
                                        <td class="text-center">
                                            <form action="{{ route('admin.dishes.restore', $dish->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn link-warning p-0 m-0 no-style">Ripristina</button>
                                            </form>
                                        </td>
                                    @endunless
                                    <td class="text-center">
                                        @if(!$dish->trashed())
                                            <form class="item-delete-form"
                                                action="{{ $dish->trashed() ? route('admin.dishes.forceDestroy', $dish) : route('admin.dishes.destroy', $dish) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-link p-0 m-0 no-style text-danger"><i
                                                        class="fas fa-trash-alt "></i></button>
                                                <div class="my-modal">
                                                    <div class="my-modal__box">
                                                        @unless($dish->trashed())
                                                            <h4 class="text-center me-5">Vuoi eliminare questo piatto?</h4>
                                                        @else
                                                            <h4 class="text-center me-5">Questa eliminazione è definitiva, sei sicuro?</h4>
                                                        @endunless
                                                        <span class="link link-danger my-modal-yes mx-5">Si</span>
                                                        <span class="link link-success my-modal-no mx-5">No</span>

                                                    </div>
                                                </div>

                                            </form>
                                        @endif
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