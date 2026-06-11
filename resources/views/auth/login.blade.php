<x-guest-layout>
    <!-- Sesijas statuss (piemēram, veiksmīga izrakstīšanās vai paroles atiestatīšana) -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- E-pasta ievades lauks -->
        <div>
            <x-input-label for="email" :value="__('E-pasts')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" 
                          :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Paroles ievades lauks -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Parole')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password" name="password"
                          required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Atcerēties mani - izvēles rūtiņa -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Atcerēties mani</span>
            </label>
        </div>

        <!-- Paroles atiestatīšanas saite un pieteikšanās poga -->
        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900"
                   href="{{ route('password.request') }}">
                    Aizmirsi paroli?
                </a>
            @endif

            <!-- Pieteikšanās poga -->
            <x-primary-button class="ms-3">
                Pieslēgties
            </x-primary-button>
        </div>

        <!-- Reģistrēšanās saite lietotājiem bez profila -->
        <div class="text-center mt-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Nav profils?
                <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">
                    Reģistrēties
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
