<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ManageTeamController extends Controller
{
    public function index()
    {
        // Paņem pašreizējo ielogojušos treneri
        $coach = Auth::user();

        // Ja trenerim vispār ir komanda, tad salasa visus tās biedrus
        if ($coach->team) {
            // Atlasa no datubāzes tos lietotājus, kam team_id sakrīt ar trenera komandas ID
            $teamMembers = User::where('team_id', $coach->team->id)->get();
        } else {
            // Ja komandas nav, uztaisa tukšu kolekciju, lai lapa nemet kļūdu
            $teamMembers = collect(); 
        }

        // Atdod biedru sarakstu uz skatu
        return view('dashboard.coach.manage-team', compact('teamMembers'));
    }

    public function removeMember($id)
    {
        // Atrod treneri un spēlētāju pēc viņa ID
        $user = Auth::user();
        $member = User::findOrFail($id);

        // Pārbauda, vai spēlētājs tiešām ir šī trenera komandā, lai nevar izdzēst svešu
        if ($member->team_id !== $user->team_id) {
            abort(403, 'Jums nav atļauts dzēst šo spēlētāju.');
        }

        // Noņem spēlētājam komandas ID un saglabā izmaiņas datubāzē
        $member->team_id = null;
        $member->save();

        // Pārlādē lapu un parāda, ka viss kārtībā
        return redirect()->back()->with('success', 'Spēlētājs tika dzēsts no komandas.');
    }
}