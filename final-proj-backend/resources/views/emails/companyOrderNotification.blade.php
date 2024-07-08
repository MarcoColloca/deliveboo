<!DOCTYPE html>
<html>
<head>
    <title>Un nuovo ordine è stato ricevuto</title>
</head>
<body>
    <h1>Un nuovo ordine è stato ricevuto</h1>
    <p>Dettagli dell'ordine:</p>
    <ul>
        <li>Nome Cliente: {{ $order->customer_name }}</li>
        <li>Indirizzo: {{ $order->customer_address }}</li>
        <li>Email: {{ $order->customer_email }}</li>
        <li>Telefono: {{ $order->customer_phone }}</li>
    </ul>

    <h5>Dettagli Ordine:</h5>
    <p>{{$order->details}}</p>

    <p>Piatti ordinati:</p>
    <ul>
        @foreach ($order->dishes as $dish)
            <li>{{ $dish->name }} x {{ $dish->pivot->qty }}</li>
        @endforeach
    </ul>
    <p>Totale: {{ $order->total }} €</p>
</body>
</html>