@extends('layouts.app')

@section('title', 'Maksājuma apstiprinājums')

@section('content')
<div class="container">
    <h1>Maksājuma apstiprinājums</h1>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Maksājuma detaļas</h4>

            <p><strong>Maksājuma ID:</strong> {{ $payment->id }}</p>
            <p><strong>Summa:</strong> {{ number_format($payment->amount, 2) }} EUR</p>
            <p><strong>Apraksts:</strong> {{ $payment->description }}</p>

            <hr>

            <form action="{{ route('payment.process', ['paymentId' => $payment->id]) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Veikt maksājumu</button>
            </form>
        </div>
    </div>
</div>
@endsection
