<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Paroles atiestatīšanas tokens -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- E-pasta adrese -->
        <div>
            <x-input-label for="email" :value="__('E-pasts')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                          :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Jaunā parole -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Jaunā parole')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password"
                          name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Apstiprināt jauno paroli -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Apstiprināt paroli')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Paroles atiestatīšanas poga -->
        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Atiestatīt paroli') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
