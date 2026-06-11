@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-semibold mb-4">{{ $practice->title }}</h1>

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <p class="text-gray-700 text-base mb-2"><strong>Apraksts:</strong> {{ $practice->description }}</p>
            <p class="text-gray-700 text-base mb-2"><strong>Laiks:</strong> {{ $practice->scheduled_at->format('Y-m-d H:i') }}</p>
            <p class="text-gray-700 text-base mb-2"><strong>Treneris:</strong> {{ $practice->coach->name ?? 'Nav norādīts' }}</p>
            <p class="text-gray-700 text-base mb-4"><strong>Komanda:</strong> {{ $practice->team->name ?? 'Nav norādīta' }}</p>

            <h2 class="text-2xl font-semibold mb-3">Dalībnieki</h2>

            @if($practice->participants->isEmpty() && $unmarkedUsers->isEmpty())
                <p>Šai aktivitātei nav reģistrētu dalībnieku un nav neatzīmējušos lietotāju.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4"> {{-- Mainīts uz 3 kolonnām --}}
                    <div>
                        <h3 class="text-xl font-medium mb-2 text-green-700">Būs ({{ $practice->participants->where('pivot.status', 'būs')->count() }})</h3>
                        <ul class="list-disc list-inside">
                            @forelse($practice->participants->where('pivot.status', 'būs') as $participant)
                                <li>{{ $participant->name }}</li>
                            @empty
                                <li>Nav neviena, kas būs.</li>
                            @endforelse
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-medium mb-2 text-red-700">Nebūs ({{ $practice->participants->where('pivot.status', 'nebus')->count() }})</h3>
                        <ul class="list-disc list-inside">
                            @forelse($practice->participants->where('pivot.status', 'nebus') as $participant)
                                <li>{{ $participant->name }}</li>
                            @empty
                                <li>Nav neviena, kas nebūs.</li>
                            @endforelse
                        </ul>
                    </div>
                    {{-- Jaunā sadaļa neatradušajiem lietotājiem --}}
                    <div>
                        <h3 class="text-xl font-medium mb-2 text-gray-700">Nav atzīmējies ({{ $unmarkedUsers->count() }})</h3>
                        <ul class="list-disc list-inside">
                            @forelse($unmarkedUsers as $user)
                                <li>{{ $user->name }}</li>
                            @empty
                                <li>Visi lietotāji ir atzīmējušies.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            @endif

            <div class="mt-6">
                <a href="{{ route('practices.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Atpakaļ pie grafika
                </a>
            </div>
        </div>
    </div>
@endsection