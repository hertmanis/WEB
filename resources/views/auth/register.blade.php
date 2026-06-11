<x-guest-layout>
    <h2 class="text-3xl font-bold mb-8 text-center">Reģistrējies kā</h2>

    <div class="grid grid-cols-2 gap-8">
        <!-- Spēlētāja sadaļa -->
        <div class="text-center">
            <a href="{{ route('register.player') }}" class="block bg-green-500 text-white text-xl py-4 px-6 rounded-lg hover:bg-green-700 transition duration-300">
                Spēlētājs
            </a>
            <div class="mt-4">
                <a href="https://www.flaticon.com/free-icons/athlete" title="athlete icons">
                    <img src="{{ asset('images/athlete.png') }}" alt="Sportista ikona" class="mx-auto w-20 h-20">
                </a>
            </div>
        </div>

        <!-- Trenera sadaļa -->
        <div class="text-center">
            <a href="{{ route('register.coach') }}" class="block bg-blue-500 text-white text-xl py-4 px-6 rounded-lg hover:bg-blue-700 transition duration-300">
                Treneris
            </a>
            <div class="mt-4">
                <a href="https://www.flaticon.com/free-icons/coach" title="coach icons">
                    <img src="{{ asset('images/coach.png') }}" alt="Trenera ikona" class="mx-auto w-20 h-20">
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
