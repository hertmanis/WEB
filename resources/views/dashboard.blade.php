@extends('layouts.app')

@section('content')
    @if(Auth::user()->role == 'player')
        @include('dashboard.player-dashboard')
    @elseif(Auth::user()->role == 'coach')
        @include('dashboard.coach-dashboard')
    @else
        <div class="container mx-auto p-8">
            <h1 class="text-3xl font-semibold text-center mb-8">
                Welcome, {{ Auth::user()->name }}!
            </h1>
            <p class="text-gray-600 text-center">Kļūda.</p>
        </div>
    @endif
@endsection
