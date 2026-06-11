<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Team; // ✅ Import the Team model
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the general registration selection view.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('auth.register'); // The view where users select Player or Coach
    }

    /**
     * Display the registration view for Players.
     *
     * @return \Illuminate\View\View
     */
    public function createPlayer(): View
    {
        return view('auth.register-player'); // A dedicated view for Player registration
    }

    /**
     * Handle Player registration.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePlayer(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:50', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'team_code' => ['required', 'exists:teams,team_code'], // Validate team code
        ]);

        // Fetch the team by its team code
        $team = Team::where('team_code', $request->team_code)->firstOrFail();

        // Create the new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 1, // Player role
            'team_id' => $team->id, // Assign player to the correct team
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Display the registration view for Coaches.
     *
     * @return \Illuminate\View\View
     */
    public function createCoach(): View
    {
        return view('auth.register-coach'); // A dedicated view for Coach registration
    }

    /**
     * Handle Coach registration.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeCoach(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 0, // Store as an integer (0 = Coach)
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
