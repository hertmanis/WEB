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
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                // Dinamiski iestatām aplikācijas valodu kalendāram (lv vai en)
                locale: '{{ app()->getLocale() }}', 
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                // Šīs pogas FullCalendar pārtulkos pats, pateicoties locales-all skriptam un mainīgajam locale
                events: {!! json_encode($practices->map(function($practice) {
                    return [
                        'title' => $practice->title,
                        'start' => $practice->scheduled_at,
                        'description' => $practice->description,
                        'id' => $practice->id,
                        'backgroundColor' => $practice->type === 'spele' ? '#ef4444' : '#3b82f6',
                        'textColor' => '#ffffff'
                    ];
                })) !!},
                eventClick: function(info) {
                    const practiceId = info.event.id;
                    window.location.href = `/practices/${practiceId}`; 
                }
            });

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
        function showInfoModal(content) {
            const modal = document.getElementById('infoModal');
            document.getElementById('infoModalContent').innerHTML = content;
            modal.classList.remove('hidden');
        }
    </script>
@endsection