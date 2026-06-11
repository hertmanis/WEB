<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ManageTeamController extends Controller
{
    public function index()
    {
        $coach = Auth::user();

        if ($coach->team) {
            // Fetch all users (both players and coach) in the same team
            $teamMembers = User::where('team_id', $coach->team->id)->get();
        } else {
            $teamMembers = collect(); // Empty collection
        }

        return view('dashboard.coach.manage-team', compact('teamMembers'));
    }

    public function removeMember($id)
{
    $user = Auth::user();
    $member = User::findOrFail($id);

    // Pārbauda, vai dalībnieks pieder pie trenera komandas
    if ($member->team_id !== $user->team_id) {
        abort(403, 'Jums nav atļauts dzēst šo spēlētāju.');
    }

    // Noņem lietotāju no komandas
    $member->team_id = null;
    $member->save();

    return redirect()->back()->with('success', 'Spēlētājs tika dzēsts no komandas.');
}
}
