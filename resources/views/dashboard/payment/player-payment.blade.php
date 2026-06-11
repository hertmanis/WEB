@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Tavi maksājumi</h2>

    @forelse($payments as $payment)
        <div class="border p-3 rounded mb-3">
            <p><strong>Apraksts:</strong> {{ $payment->description }}</p>
            <p><strong>Summa:</strong> €{{ number_format($payment->amount / 100, 2) }}</p>
            <p><strong>Statuss:</strong> 
                {{ $payment->status === 'paid' ? 'Apmaksāts' : 'Neapmaksāts' }}
            </p>

            @if($payment->status !== 'paid')
                <a href="{{ route('payment.pay', $payment->id) }}"
                   class="mt-3 inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                    Veikt maksājumu
                </a>
            @endif
        </div>
    @empty
        <p>Nav maksājumu.</p>
    @endforelse
</div>
@endsection
