@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4">
        <h1 class="text-4xl font-bold text-center text-green-700 mb-10">
            Sveicināts, {{ Auth::user()->name }}! 
        </h1>

        <div class="bg-gradient-to-br from-green-100 to-green-200 p-6 rounded-xl shadow-lg transition hover:shadow-2xl">
            <div class="flex items-center gap-4 mb-4">
                
                <div>
                    <h2 class="text-2xl font-semibold">Trenera panelis</h2>
                    <p class="text-gray-700">Pārvaldi savu komandu un uzaicini spēlētājus!</p>
                </div>
            </div>

            @if(Auth::user()->team)
                <div class="mt-6 bg-white border border-green-200 p-5 rounded-xl shadow-inner">
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Komandas kods</h3>
                    <div class="flex items-center justify-between">
                        <p class="text-3xl font-mono text-green-700 tracking-wider">
                            {{ Auth::user()->team->team_code }}
                        </p>
                        <button onclick="navigator.clipboard.writeText('{{ Auth::user()->team->team_code }}')" class="text-sm text-green-600 hover:underline">
                            Kopēt kodu
                        </button>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Dalies ar šo kodu, lai spēlētāji varētu pievienoties komandai.</p>
                </div>
            @else
                <p class="text-red-600 mt-6 font-medium">Jums vēl nav pievienota komanda.</p>
            @endif
        </div>
    </div>
@endsection
