<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Change the user's password.
     */
    public function changePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => [
                'required',
                'confirmed',
                'min:8',
                'max:25',
                'regex:/[A-Z]/',    // At least one uppercase letter
                'regex:/[a-z]/',    // At least one lowercase letter
                'regex:/[0-9]/',    // At least one number
                'regex:/[\W]/',     // At least one special character
            ],
        ], [
            'new_password.regex' => 'Parolei jāsatur vismaz viens lielais burts, viens mazais burts, viens cipars un viena speciālā rakstzīme.',
            'new_password.min' => 'Parolei jābūt vismaz 8 rakstzīmju garai.',
            'new_password.max' => 'Parole nevar būt garāka par 25 rakstzīmēm.',
        ]);

        // Verify current password
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Pašreizējā parole ir nepareiza.',
            ]);
        }

        // Update password
        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return Redirect::route('profile.edit')->with('status', 'password-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
