@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4">
        <h1 class="text-4xl font-bold text-center text-blue-700 mb-10">
            Sveicināts savā spēlētāja panelī, {{ Auth::user()->name }}! ⚽
        </h1>

        <div class="bg-gradient-to-br from-blue-100 to-blue-200 p-6 rounded-xl shadow-lg transition hover:shadow-2xl">
            <div class="flex items-center gap-4 mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <div>
                    <h2 class="text-2xl font-semibold">Spēlētāja panelis</h2>
                    <p class="text-gray-700">Šeit vari redzēt savus nākamos treniņus un spēles, veikt samaksu, un komandas info.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
