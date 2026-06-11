<?php
namespace App\Http\Controllers;

use App\Models\Practice;
use App\Models\User;
use Illuminate\Http\Request;

class ParticipationController extends Controller
{
    public function status(Practice $practice, User $user)
    {
        $participation = $practice->participants()->where('user_id', $user->id)->first();
        $status = $participation ? $participation->pivot->status : 'nebus';

        return response()->json([
            'title' => $practice->title,
            'status' => $status,
        ]);
    }

    public function update(Request $request, Practice $practice, User $user)
    {
        $status = $request->input('status', 'nebus');

        $practice->participants()->syncWithoutDetaching([
            $user->id => ['status' => $status],
        ]);

        return response()->json([
            'message' => 'Dalības statuss atjaunināts uz: ' . $status
        ]);
    }
}
