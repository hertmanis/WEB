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
    </div>
</section>


</x-layout>
