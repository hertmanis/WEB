@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold text-center mb-8">
        Laipni lūgti trenera panelī, {{ Auth::user()->name }}!
    </h1>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-green-100 p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-xl font-semibold">Trenera panelis</h2>
        <p>Pārvaldiet savas komandas sastāvu.</p>

        @if(Auth::user()->team)
            <div class="mt-4 bg-white p-4 rounded shadow">
                <h3 class="text-lg font-semibold">Jūsu komandas kods</h3>
                <p class="text-2xl font-bold text-green-700">{{ Auth::user()->team->team_code }}</p>
                <p class="text-gray-600">Kopīgojiet šo kodu ar spēlētājiem, lai viņi varētu pievienoties komandai.</p>
            </div>

            <div class="mt-6 bg-white p-4 rounded shadow">
                <h3 class="text-lg font-semibold">Komandas dalībnieki</h3>

                @if($teamMembers->count() > 0)
                    <ul class="mt-2 space-y-2">
                        @foreach($teamMembers as $member)
                            <li class="bg-gray-100 p-2 rounded flex justify-between items-center">
                                <div>
                                    <span class="font-medium">{{ $member->name }}</span> - {{ $member->email }} 
                                    <span class="text-sm text-gray-600">
                                        ({{ intval($member->role) === 0 ? 'Treneris' : 'Spēlētājs' }})
                                    </span>
                                </div>

                                <form action="{{ route('team.removeMember', $member->id) }}" method="POST" onsubmit="return confirm('Vai tiešām vēlaties dzēst šo spēlētāju?');">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-lg" aria-label="Dzēst dalībnieku">×</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 mt-2">Neviens dalībnieks vēl nav pievienojies komandai.</p>
                @endif
            </div>
        @else
            <p class="text-red-500 font-semibold">Jūs vēl neesat pievienots nevienai komandai.</p>
        @endif
    </div>
@endsection