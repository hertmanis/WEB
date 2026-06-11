<x-layout>
    <x-slot name="title">
        Universāls Risinājums - TeamManager
    </x-slot>

    <section class="h-[calc(100vh-4rem)] flex flex-col justify-center items-center text-center bg-[#124E66] bg-[url('/images/sports.png')] bg-cover bg-no-repeat bg-center">
    <div class="bg-black/90 p-8 rounded-lg">
        <h1 class="text-4xl font-bold mb-4 text-white">Universāls risinājums sporta klubu vadībai</h1>
        <p class="text-lg mb-8 max-w-2xl mx-auto leading-relaxed text-white">
            Komandas pārvaldības sistēma, kas nodrošina efektīvu dalībnieku pārvaldību, plānošanu un komunikāciju.
        </p>
        <div class="flex justify-center space-x-4">
        <button 
        onclick="window.location.href='/register'" 
        class="bg-[#2E3944] hover:bg-[#748D92] text-white font-bold py-3 px-6 rounded">
        Piereģistrēties
        </button>

            <button
            onclick="window.location.href='/login'" 
             class="bg-[#124E66] hover:bg-[#166F88] text-white font-bold py-3 px-6 rounded">
                Ienākt
            </button>
        </div>
        <p class="mt-4 text-sm text-[#D3D9D4]">
            Piereģistrējoties nav nepieciešama kreditkarte.
        </p>
    </div>
</section>




    <!-- Features Section -->
    <section class="py-20 text-center bg-[#D3D9D4]">
        <h2 class="text-3xl font-semibold mb-4 text-[#212A31]">Galvenās Iespējas</h2>
        <p class="text-lg mb-8 max-w-2xl mx-auto leading-relaxed text-[#2E3944]">
            Izmantojiet mūsu platformu, lai vienkāršotu komandas vadību, plānošanu un spēlētāju attīstību.
        </p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
        <div class="p-6 bg-white/20 rounded-lg shadow-lg backdrop-blur-sm">
                <h3 class="text-2xl font-semibold mb-4">Dalības vadība</h3>
                <p>Pievienojiet spēlētājus, pārvaldiet kontaktus un sekojiet līdzi viņu progresam.</p>
            </div>
            <div class="p-6 bg-white/20 rounded-lg shadow-lg backdrop-blur-sm">
                <h3 class="text-2xl font-semibold mb-4">Aktivitāšu plānošana</h3>
                <p>Izveidojiet grafikus, plānojiet sacensības un sekojiet līdzi apmeklējumam.</p>
            </div>
            <div class="p-6 bg-white/20 rounded-lg shadow-lg backdrop-blur-sm">
                <h3 class="text-2xl font-semibold mb-4">Komunikācija</h3>
                <p>Nodrošiniet ātru un efektīvu saziņu ar treneriem un spēlētājiem.</p>
            </div>
        </div>
    </section>

    <!-- All-in-One Solution Section -->
    <section class="py-20 bg-[#D3D9D4]">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold mb-8 text-[#212A31]">Viss vienā risinājums</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="p-6 bg-white/20 rounded-lg shadow-lg backdrop-blur-sm">
                    <h3 class="text-2xl font-semibold mb-4 text-[#212A31]">Dalības vadība</h3>
                    <p class="text-[#2E3944]">Reģistrējiet un pārvaldiet spēlētājus ar vienkāršiem un efektīviem rīkiem.</p>
                </div>
                <div class="p-6 bg-white/20 rounded-lg shadow-lg backdrop-blur-sm">
                    <h3 class="text-2xl font-semibold mb-4 text-[#212A31]">Finanšu pārvaldība</h3>
                    <p class="text-[#2E3944]">Izveidojiet rēķinus, sekojiet maksājumiem un automatizējiet atgādinājumus.</p>
                </div>
                <div class="p-6 bg-white/20 rounded-lg shadow-lg backdrop-blur-sm">
                    <h3 class="text-2xl font-semibold mb-4 text-[#212A31]">Spēlētāju progress</h3>
                    <p class="text-[#2E3944]">Kalendārs, RSVP funkcijas un apmeklējumu grafiks spēlētāju attīstībai.</p>
                </div>
            </div>
        </div>
    </section>
</x-layout>
