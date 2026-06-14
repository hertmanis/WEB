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
    // Atver lietotāja profila rediģēšanas lapu
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(), // Iedod līdzi pašreizējā lietotāja datus
        ]);
    }

    // Saglabā jauno profila info (vārdu, e-pastu utt.)
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Piepilda modeli ar pārbaudītajiem datiem
        $request->user()->fill($request->validated());

        // Ja e-pasts ir nomainīts, noņemam verifikācijas datumu
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Saglabā izmaiņas datubāzē
        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    // Parole maiņas funkcija ar stingriem drošības noteikumiem
    public function changePassword(Request $request): RedirectResponse
    {
        // Validācija, kas pārbauda jaunās paroles sarežģītību ar regex
        $request->validate([
            'current_password' => ['required'],
            'new_password' => [
                'required',
                'confirmed', // Pārbauda, vai abos paroles laukos ierakstīts viens un tas pats
                'min:8',
                'max:25',
                'regex:/[A-Z]/',    // Vajag vismaz vienu lielo burtu
                'regex:/[a-z]/',    // Vajag vismaz vienu mazo burtu
                'regex:/[0-9]/',    // Vajag vismaz vienu ciparu
                'regex:/[\W]/',     // Vajag vismaz vienu speciālo simbolu
            ],
        ], [
            // Paziņojumi latviski, ja validācija neiziet
            'new_password.regex' => 'Parolei jāsatur vismaz viens lielais burts, viens mazais burts, viens cipars un viena speciālā rakstzīme.',
            'new_password.min' => 'Parolei jābūt vismaz 8 rakstzīmju garai.',
            'new_password.max' => 'Parole nevar būt garāka par 25 rakstzīmēm.',
        ]);

        // Pārbauda, vai ievadītā vecā parole vispār sakrīt ar to, kas ir datubāzē
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Pašreizējā parole ir nepareiza.',
            ]);
        }

        // Ja viss sakrīt, nohešo jauno paroli un saglabā
        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return Redirect::route('profile.edit')->with('status', 'password-updated');
    }

    // Pilnīga lietotāja konta dzēšana no sistēmas
    public function destroy(Request $request): RedirectResponse
    {
        // Drošībai paprasa vēlreiz ievadīt paroli pirms dzēšanas
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Izlogojas no sistēmas
        Auth::logout();

        // Izdzēš lietotāja rindu no datubāzes tabulas
        $user->delete();

        // Notīra un anulē sesiju, lai nekas nepaliek pārlūkā
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Pārmet lietotāju uz sākumlapu
        return Redirect::to('/');
    }
}