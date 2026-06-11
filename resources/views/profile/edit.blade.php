@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold text-center mb-8">Profila iestatījumi</h1>

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <!-- Veiksmīgas izmaiņas ziņojums -->
        @if (session('status') === 'profile-updated')
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                Profils veiksmīgi atjaunināts!
            </div>
        @elseif (session('status') === 'password-updated')
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                Parole veiksmīgi nomainīta!
            </div>
        @endif

        <!-- Profila atjaunināšanas forma -->
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <!-- Vārds -->
            <div class="mb-4">
                <label class="block font-medium">Vārds</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                    class="w-full border-gray-300 rounded p-2">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- E-pasts -->
            <div class="mb-4">
                <label class="block font-medium">E-pasts</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                    class="w-full border-gray-300 rounded p-2">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Atjaunināt profilu
            </button>
        </form>

        <hr class="my-6">

        <!-- Paroles maiņas forma -->
        <h2 class="text-xl font-semibold">Mainīt paroli</h2>
        <form method="POST" action="{{ route('profile.change-password') }}">
            @csrf
            @method('PATCH')

            <!-- Pašreizējā parole -->
            <div class="mb-4">
                <label class="block font-medium">Pašreizējā parole</label>
                <input type="password" name="current_password" required class="w-full border-gray-300 rounded p-2">
                @error('current_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jaunā parole -->
            <div class="mb-4">
                <label class="block font-medium">Jaunā parole</label>
                <input type="password" name="new_password" required class="w-full border-gray-300 rounded p-2">
                @error('new_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Apstiprināt jauno paroli -->
            <div class="mb-4">
                <label class="block font-medium">Apstiprināt jauno paroli</label>
                <input type="password" name="new_password_confirmation" required class="w-full border-gray-300 rounded p-2">
            </div>

            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Mainīt paroli
            </button>
        </form>
    </div>
@endsection
