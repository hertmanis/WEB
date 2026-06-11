@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Maksājums veiksmīgs</h2>
    <p><strong>Apraksts:</strong> {{ $payment->description }}</p>
    <p><strong>Summa:</strong> €{{ number_format($payment->amount / 100, 2) }}</p>
    <p class="text-green-600 font-bold mt-4">Maksājums ir veiksmīgi apstiprināts!</p>
</div>
@endsection
