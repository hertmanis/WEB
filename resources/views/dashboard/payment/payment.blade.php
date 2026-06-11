@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-10 p-6 bg-white rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Izveidot maksājumu</h2>

    <form action="{{ route('stripe.checkout') }}" method="POST" id="payment-form">
        @csrf

        <div class="mb-4">
            <label for="amount" class="block font-medium">Summa (€)</label>
            <input type="number" name="amount" id="amount" min="1" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block font-medium">Apraksts</label>
            <input type="text" name="description" id="description" class="w-full border p-2 rounded" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
            Izveidot maksājumu
        </button>
    </form>
</div>
@endsection
