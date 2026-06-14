@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold text-center mb-8">
        {{ __('Aktivitāšu grafiks') }}
    </h1>

    <div class="flex justify-end mb-4">
        <a href="{{ route('practices.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + {{ __('Pievienot aktivitāti') }}
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div id="calendar"></div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales-all.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Atrod tukšo kalendāra div elementu
            const calendarEl = document.getElementById('calendar');

            // Inicializē kalendāru un uzstāda tā opcijas
            const calendar = new FullCalendar.Calendar(calendarEl, {
                // Paņem pašreizējo sistēmas valodu (lv vai en)
                locale: '{{ app()->getLocale() }}', 
                initialView: 'dayGridMonth', // Noklusējuma skats ir mēnesis
                headerToolbar: {
                    left: 'prev,next today', // Pogas kreisajā pusē iepriekšējais, nākamais, šodiena
                    center: 'title',         // Vidū rādīs mēneša/nedēļas nosaukumu
                    right: 'dayGridMonth,timeGridWeek,timeGridDay' // Skatu pārslēdzēji labajā pusē
                },
                
                // Pārveidoj Laravel atsūtītos treniņu datus par JSON masīvu, ko saprot FullCalendar
                events: {!! json_encode($practices->map(function($practice) {
                    return [
                        'title' => $practice->title,
                        'start' => $practice->scheduled_at,
                        'description' => $practice->description,
                        'id' => $practice->id,
                        // Ja tips ir spele, krāso sarkanu, ja treniņš - zilu 
                        'backgroundColor' => $practice->type === 'spele' ? '#ef4444' : '#3b82f6',
                        'textColor' => '#ffffff'
                    ];
                })) !!},
                
                // Kas notiek, kad uzklikšķina uz kāda pasākuma kalendārā
                eventClick: function(info) {
                    const practiceId = info.event.id;
                    // Pārmet lietotāju uz konkrētā treniņa detaļu lapu
                    window.location.href = `/practices/${practiceId}`; 
                }
            });

            // Palaiž un uzzīmē kalendāru ekrānā
            calendar.render();
        });
    </script>

    <div id="infoModal" class="fixed inset-0 z-50 bg-gray-800 bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded p-6 max-w-md w-full relative">
            <div id="infoModalContent" class="text-sm leading-relaxed"></div>
            <button onclick="document.getElementById('infoModal').classList.add('hidden')"
                    class="absolute top-2 right-2 text-gray-600 font-bold" aria-label="{{ __('Aizvērt') }}">X</button>
        </div>
    </div>

    <script>
        // Funkcija, ar kuru var smuki parādīt uzlecošo logu ar vajadzīgo tekstu
        function showInfoModal(content) {
            const modal = document.getElementById('infoModal');
            document.getElementById('infoModalContent').innerHTML = content;
            modal.classList.remove('hidden'); // Noņem 'hidden' klasi, lai logs kļūtu redzams
        }
    </script>
@endsection