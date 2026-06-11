<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center">Reģistrācija kā spēlētājam</h2>

            <!-- Kļūdu attēlošana -->
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.player.store') }}">
                @csrf
                
                <!-- Vārda lauks -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Vārds</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <!-- E-pasta lauks -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">E-pasts</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <!-- Paroles lauks -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Parole</label>
                    <input type="password" name="password" id="password" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <!-- Paroles apstiprināšana -->
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Apstiprini paroli</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <!-- Komandas koda lauks -->
                <div class="mb-4">
                    <label for="team_code" class="block text-sm font-medium text-gray-700">Komandas kods</label>
                    <input type="text" name="team_code" id="team_code" value="{{ old('team_code') }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Ievadi savas komandas kodu">
                </div>

                <!-- Reģistrācijas poga -->
                <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Reģistrēties kā spēlētājs
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
