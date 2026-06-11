@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-md">
    <h1 class="text-3xl font-bold text-center text-indigo-700 mb-6">
        💳 Maksājuma informācija
    </h1>

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="space-y-4">
        <p class="text-lg"><strong>📝 Apraksts:</strong> {{ $payment->description }}</p>
        <p class="text-lg"><strong>💰 Summa:</strong> €{{ number_format($payment->amount / 100, 2) }}</p>
    </div>

    <form action="{{ route('payment.checkout', ['paymentId' => $payment->id]) }}" method="POST" class="mt-6">
        @csrf
        <button type="submit"
            class="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg text-lg font-semibold hover:bg-indigo-700 transition">
            Veikt maksājumu ar Stripe
        </button>
    </form>

    <p class="text-sm text-center text-gray-500 mt-4">
        Tavu maksājumu apstrādā Stripe – drošs un uzticams maksājumu nodrošinātājs.
    </p>
</div>
@endsection
