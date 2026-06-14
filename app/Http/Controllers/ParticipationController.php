<?php
namespace App\Http\Controllers;

use App\Models\Practice;
use App\Models\User;
use Illuminate\Http\Request;

class ParticipationController extends Controller
{
    public function status(Practice $practice, User $user)
    {
        // Atrod konkrēto lietotāju pie šī treniņa dalībniekiem
        $participation = $practice->participants()->where('user_id', $user->id)->first();
        
        // Ja viņš ir sarakstā, paņem statusu no starptabulas, ja nav - pēc noklusējuma ir 'nebus'
        $status = $participation ? $participation->pivot->status : 'nebus';

        // Atdod treniņa nosaukumu un statusu JSON formātā priekšgalam
        return response()->json([
            'title' => $practice->title,
            'status' => $status,
        ]);
    }

    public function update(Request $request, Practice $practice, User $user)
    {
        // Paņem jauno statusu no pieprasījuma, ja nav atsūtīts - uzliek 'nebus'
        $status = $request->input('status', 'nebus');

        // Atjaunina datus starptabulā. syncWithoutDetaching nodrošina, ka nepazaudē citu spēlētāju datus
        $practice->participants()->syncWithoutDetaching([
            $user->id => ['status' => $status],
        ]);

        // Nosūta atpakaļ paziņojumu, ka viss veiksmīgi saglabāts
        return response()->json([
            'message' => 'Dalības statuss atjaunināts uz: ' . $status
        ]);
    }
}