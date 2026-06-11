@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold text-center mb-8">
        {{ __('Ieplānot aktivitāti') }}
    </h1>

    <div class="bg-white p-6 rounded shadow-md max-w-lg mx-auto">
        <form method="POST" action="{{ route('practices.store') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="title">
                    {{ __('Nosaukums') }}
                </label>
                <input type="text" name="title" id="title" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="description">
                    {{ __('Aktivitātes apraksts') }}
                </label>
                <textarea name="description" id="description" class="w-full p-2 border rounded"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="scheduled_at">
                    {{ __('Laiks un datums') }}
                </label>
                <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="type">
                    {{ __('Aktivitātes veids') }}
                </label>
                <select name="type" id="type" class="w-full p-2 border rounded" required>
                    <option value="trenins">{{ __('Treniņš') }}</option>
                    <option value="spele">{{ __('Spēle') }}</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                {{ __('Izveidot') }}
            </button>
        </form>
    </div>
@endsection