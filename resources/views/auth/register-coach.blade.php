<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center">Register as Coach</h2>
            <form method="POST" action="{{ route('register.coach.store') }}">
                @csrf
                <!-- Name Input -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium">Name</label>
                    <input type="text" id="name" name="name" class="border border-gray-300 rounded w-full px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" required>
                </div>

                <!-- Email Input -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium">Email</label>
                    <input type="email" id="email" name="email" class="border border-gray-300 rounded w-full px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" required>
                </div>

                <!-- Password Input -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-medium">Password</label>
                    <input type="password" id="password" name="password" class="border border-gray-300 rounded w-full px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" required>
                </div>

                <!-- Confirm Password Input -->
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700 font-medium">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="border border-gray-300 rounded w-full px-3 py-2 focus:outline-none focus:ring focus:border-blue-500" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-300">
                    Register
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
