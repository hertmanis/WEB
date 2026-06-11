@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Izveidot maksājumu</h2>

    @if(session('status'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('coach.payments.store') }}">
        @csrf
        <div class="mb-4">
            <label for="description" class="block font-medium">Apraksts</label>
            <input type="text" name="description" id="description" required class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label for="amount" class="block font-medium">Summa (€)</label>
            <input type="number" name="amount" id="amount" min="1" required class="w-full p-2 border rounded">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Izveidot</button>
    </form>

    <hr class="my-6">

    <h3 class="text-lg font-semibold mb-2">Eksistējošie maksājumi</h3>
    @foreach($payments as $payment)
        <div class="border p-3 rounded mb-3">
            <p><strong>Apraksts:</strong> {{ $payment->description }}</p>
            <p><strong>Summa:</strong> €{{ number_format($payment->amount / 100, 2) }}</p>
            <p><strong>Izveidots:</strong> {{ $payment->created_at->format('d.m.Y H:i') }}</p>
        </div>
    @endforeach
</div>
@endsection
