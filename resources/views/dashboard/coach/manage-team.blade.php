@extends('layouts.app')

@section('content')
    <!-- Galvenais virsraksts ar lietotāja vārdu -->
    <h1 class="text-3xl font-semibold text-center mb-8">
        Laipni lūgti trenera panelī, {{ Auth::user()->name }}!
    </h1>

    <!-- Veiksmes ziņojuma attēlošana, ja ir pieejams -->
    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Galvenais paneļa konteiners -->
    <div class="bg-green-100 p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-xl font-semibold">Trenera panelis</h2>
        <p>Pārvaldiet savas komandas sastāvu.</p>

        <!-- Pārbauda, vai lietotājam ir pievienota komanda -->
        @if(Auth::user()->team)
            <!-- Komandas kods, ko var kopīgot ar spēlētājiem -->
            <div class="mt-4 bg-white p-4 rounded shadow">
                <h3 class="text-lg font-semibold">Jūsu komandas kods</h3>
                <p class="text-2xl font-bold text-green-700">{{ Auth::user()->team->team_code }}</p>
                <p class="text-gray-600">Kopīgojiet šo kodu ar spēlētājiem, lai viņi varētu pievienoties komandai.</p>
            </div>

            <!-- Komandas dalībnieku saraksts -->
            <div class="mt-6 bg-white p-4 rounded shadow">
                <h3 class="text-lg font-semibold">Komandas dalībnieki</h3>

                <!-- Ja ir kādi komandas dalībnieki -->
                @if($teamMembers->count() > 0)
                    <ul class="mt-2 space-y-2">
                        @foreach($teamMembers as $member)
                            <li class="bg-gray-100 p-2 rounded flex justify-between items-center">
                                <div>
                                    <!-- Attēlo dalībnieka vārdu, e-pastu un lomu -->
                                    <span class="font-medium">{{ $member->name }}</span> - {{ $member->email }} 
                                    <span class="text-sm text-gray-600">
                                        ({{ intval($member->role) === 0 ? 'Treneris' : 'Spēlētājs' }})
                                    </span>
                                </div>

                                <!-- Forma, lai dzēstu dalībnieku no komandas -->
                                <form action="{{ route('team.removeMember', $member->id) }}" method="POST" onsubmit="return confirm('Vai tiešām vēlaties dzēst šo spēlētāju?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-lg">×</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <!-- Ja komandā vēl nav neviena dalībnieka -->
                    <p class="text-gray-500 mt-2">Neviens dalībnieks vēl nav pievienojies komandai.</p>
                @endif
            </div>
        @else
            <!-- Ja lietotājam nav pievienota komanda -->
            <p class="text-red-500 font-semibold">Jūs vēl neesat pievienots nevienai komandai.</p>
        @endif
    </div>
@endsection
