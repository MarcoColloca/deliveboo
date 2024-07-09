@extends('layouts.app')

@section('title', $company->name)

<?php
    $slug = $company->slug;
    $frontendUrl = 'http://localhost';
    $frontendPort = env('APP_FRONTEND_PORT');
    $url = "{$frontendUrl}:{$frontendPort}/menu/{$slug}";
?>

@section('content')


<section class="container bg-light mt-5 mb-5 rounded-4 p-5 text-blue shadow">
    <h2 class="mb-3 text-center ">
        <a class="text-decoration-none btn btn-outline-blue" href="<?php  echo htmlspecialchars($url); ?>">
            Il tuo Menu su Fooder
        </a>
    </h2>
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mt-5">
            <h1 class="text-blue text-center">
                {{$company->name}}
            </h1>
            @unless (request('trash'))
                <a class="btn btn-outline-warning text-decoration-none d-flex align-items-center h-75 px-2"
                    href="{{ route('admin.dishes.create', ['company_id' => $company->id])}}"><i class="fas fa-plus"></i>
                </a>

                <a href="{{ route('admin.dishes.showOne', ['dish' => $company->id, 'trash' => 1])}}"
                    class="btn btn-link p-0 m-0 no-style text-danger align-content-center">
                    <i class="fas fa-trash-alt "></i>
                </a>
            @elseif (request('trash'))
            <a href="{{ route('admin.dishes.showOne', ['dish' => $company->id])}}"
                class="btn link-primary p-0 m-0 no-style align-content-center">Indietro</a>
            @endif
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <table class="table">
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
                                <td class="text-center">{{ $dish->price}} €</td>
                                <td class="text-center">{{ $dish->visible === 1 ? 'Sì' : 'No'}}</td>
                                @unless($dish->trashed())
                                    <td class="text-center">
                                        <a href="{{ route('admin.dishes.show', $dish) }}" class="link link-success">Dettagli</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.dishes.edit', $dish) }}" class="link link-primary">Modifica</a>
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
                                    <form class="item-delete-form"
                                        action="{{$dish->trashed() ? route('admin.dishes.forceDestroy', $dish) : route('admin.dishes.destroy', $dish) }}"
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
            </div>
        </div>
    </div>
</section>

@endsection