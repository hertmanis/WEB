<x-layout>
    <x-slot name="title">
        Iespējas - TeamManager
    </x-slot>

    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-semibold mb-8 text-center">Mūsu Iespējas</h2>

            <div class="flex space-x-4">
                <!-- Left Column: Options List -->
                <div class="w-1/3 bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-semibold mb-4">Spēlētājiem</h3>
                    <ul class="space-y-4 mb-8">
                        <li>
                            <button 
                                onclick="showDetails('playerLoad')" 
                                class="text-blue-500 hover:text-blue-700 font-bold w-full text-left">
                                Apskatīt savu slodzes grafiku
                            </button>
                        </li>
                        <li>
                            <button 
                                onclick="showDetails('playerSchedule')" 
                                class="text-blue-500 hover:text-blue-700 font-bold w-full text-left">
                                Izpētīt savu grafiku
                            </button>
                        </li>
                        <li>
                            <button 
                                onclick="showDetails('playerAttendance')" 
                                class="text-blue-500 hover:text-blue-700 font-bold w-full text-left">
                                Atzīmēties par treniņiem/spēlēm
                            </button>
                        </li>
                        <li>
                            <button 
                                onclick="showDetails('playerPayment')" 
                                class="text-blue-500 hover:text-blue-700 font-bold w-full text-left">
                                Pievienot savu maksāšanas metodi
                            </button>
                        </li>
                        <li>
                            <button 
                                onclick="showDetails('playerPayExpenses')" 
                                class="text-blue-500 hover:text-blue-700 font-bold w-full text-left">
                                Apmaksāt treniņus vai citus izdevumus
                            </button>
                        </li>
                    </ul>

                    <h3 class="text-xl font-semibold mb-4">Treneriem</h3>
                    <ul class="space-y-4">
                        <li>
                            <button 
                                onclick="showDetails('coachTeams')" 
                                class="text-blue-500 hover:text-blue-700 font-bold w-full text-left">
                                Apskatīt savas komandas
                            </button>
                        </li>
                        <li>
                            <button 
                                onclick="showDetails('coachPlayers')" 
                                class="text-blue-500 hover:text-blue-700 font-bold w-full text-left">
                                Pievienot vai izņemt spēlētājus
                            </button>
                        </li>
                        <li>
                            <button 
                                onclick="showDetails('coachNotifications')" 
                                class="text-blue-500 hover:text-blue-700 font-bold w-full text-left">
                                Nosūtīt paziņojumu spēlētājiem
                            </button>
                        </li>
                        <li>
                            <button 
                                onclick="showDetails('coachPayments')" 
                                class="text-blue-500 hover:text-blue-700 font-bold w-full text-left">
                                Apskatīties, kurš no spēlētājiem ir samaksājis
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Right Column: Details -->
                <div id="details" class="w-2/3 bg-gray-100 rounded-lg shadow-lg p-6">
                    <h3 class="text-2xl font-semibold mb-4">Izvēlieties iespēju no kreisās puses</h3>
                    <p class="text-gray-700">
                        Šeit tiks parādīta detalizēta informācija par izvēlēto iespēju.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <script>
        const detailsData = {
            playerLoad: {
                title: "Apskatīt savu slodzes grafiku",
                content: `
                    <p class="text-gray-700">
                        Dabūt informāciju no grafika par savu ķermeņa slodzi un optimizēt savu treniņu plānu.
                    </p>
                `
            },
            playerSchedule: {
                title: "Izpētīt savu grafiku",
                content: `
                    <p class="text-gray-700">
                        Apskatīties, kad notiek treniņi vai spēles, kā arī dot atgriezenisko atsauksmi par tiem.
                    </p>
                `
            },
            playerAttendance: {
                title: "Atzīmēties par treniņiem/spēlēm",
                content: `
                    <p class="text-gray-700">
                        Atzīmējiet, ka piedalīsieties, vai sniedziet iemeslu, ja nevarat piedalīties.
                    </p>
                `
            },
            playerPayment: {
                title: "Pievienot savu maksāšanas metodi",
                content: `
                    <p class="text-gray-700">
                        Nodrošiniet ērtu maksāšanas iespēju, pievienojot savu maksājumu informāciju.
                    </p>
                `
            },
            playerPayExpenses: {
                title: "Apmaksāt treniņus vai citus izdevumus",
                content: `
                    <p class="text-gray-700">
                        Veiciet maksājumus tieši caur mājaslapu par treniņiem vai citām izmaksām.
                    </p>
                `
            },
            coachTeams: {
                title: "Apskatīt savas komandas",
                content: `
                    <p class="text-gray-700">
                        Pārvaldiet informāciju par katru no savām komandām, ja esat vairāku komandu treneris.
                    </p>
                `
            },
            coachPlayers: {
                title: "Pievienot vai izņemt spēlētājus",
                content: `
                    <p class="text-gray-700">
                        Pievienojiet jaunus spēlētājus vai noņemiet tos, kuri pamet komandu.
                    </p>
                `
            },
            coachNotifications: {
                title: "Nosūtīt paziņojumu spēlētājiem",
                content: `
                    <p class="text-gray-700">
                        Ātri un viegli nosūtiet paziņojumus visiem komandas spēlētājiem.
                    </p>
                `
            },
            coachPayments: {
                title: "Apskatīties, kurš no spēlētājiem ir samaksājis",
                content: `
                    <p class="text-gray-700">
                        Pārbaudiet, kuri spēlētāji ir veikuši maksājumus un kuri vēl nē.
                    </p>
                `
            }
        };

        function showDetails(option) {
            const detailContainer = document.getElementById('details');
            const detail = detailsData[option];

            if (detail) {
                detailContainer.innerHTML = `
                    <h3 class="text-2xl font-semibold mb-4">${detail.title}</h3>
                    ${detail.content}
                `;
            }
        }
    </script>
</x-layout>
