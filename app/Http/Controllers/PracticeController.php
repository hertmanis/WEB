<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Practice;
use App\Models\Participation;

class PracticeController extends Controller
{
    public function index()
    {
        // Paņem ielogojušos lietotāju
        $user = Auth::user();
    
        // Ja viņam ir komanda, atlasa visus šīs komandas treniņus
        if ($user->team) {
            $practices = Practice::where('team_id', $user->team->id)->get();
        } else {
            // Ja komandas nav, iedod tukšu sarakstu, lai nemet kļūdu
            $practices = collect(); 
        }
    
        // Atkarībā no lomas aizsūta uz pareizo skatu (0 - treneris, pārējie - spēlētājs)
        if ($user->role == 0) { 
            return view('dashboard.coach.coach-practice', compact('practices', 'user'));
        } else {
            return view('dashboard.player.player-practice', compact('practices', 'user'));
        }
    }
    
    public function create()
    {
        // Atver formu jaunā treniņa izveidošanai
        return view('dashboard.coach.create-practice');
    }

    public function store(Request $request)
    {
        // Pārbauda ievaddatus, lai viss būtu pareizi aizpildīts
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scheduled_at' => 'required|date|after:today', // Laikam jābūt uz priekšu, nevis pagātnē
            'type' => 'required|in:trenins,spele',
        ]);
    
        // Ieraksta jauno aktivitāti datubāzē
        Practice::create([
            'team_id' => Auth::user()->team->id,
            'coach_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'scheduled_at' => $request->scheduled_at,
            'type' => $request->type,
        ]);
    
        // Pārmet atpakaļ uz sarakstu ar panākumu ziņojumu
        return redirect()->route('practices.index')->with('success', 'Aktivitāte veiksmīgi ieplānota.');
    }
    
    public function destroy($id)
    {
        // Atrod konkrēto treniņu pēc ID
        $practice = Practice::findOrFail($id);

        // Pārbauda, vai šis ir paša trenera treniņš, lai nevar izdzēst svešus
        if ($practice->coach_id !== Auth::id()) {
            return redirect()->route('practices.index')->with('error', 'You can only delete your own practices.');
        }

        // Izdzēš no datubāzes
        $practice->delete();

        return redirect()->route('practices.index')->with('success', 'Practice deleted successfully.');
    }

    public function getParticipationStatus($practiceId, $userId)
    {
        // Atrod, vai lietotājs jau ir atzīmējies šim treniņam
        $participation = Participation::where('practice_id', $practiceId)
                                       ->where('user_id', $userId)
                                       ->first();

        // Ja ieraksts ir, atdod statusu, ja nav - uzskata, ka 'nebus'
        $status = $participation ? $participation->status : 'nebus';

        // Atdod statusu JSON formātā priekšgalam
        return response()->json(['status' => $status]);
    }

    public function updateParticipationStatus($practiceId, $userId, Request $request)
    {
        $status = $request->input('status');

        // Ja ieraksts jau ir - atjaunina, ja nav - izveido jaunu (updateOrCreate)
        $participation = Participation::updateOrCreate(
            ['practice_id' => $practiceId, 'user_id' => $userId],
            ['status' => $status]
        );

        // Nosūta atpakaļ JSON ziņojumu, ka statuss saglabāts
        return response()->json(['message' => 'Jūsu piedalīšanās statuss ir atjaunināts!']);
    }

    public function participants($id)
    {
        // Atlasa treniņu kopā ar visiem dalībniekiem (tikai ID, vārdu un statusu no pivot tabulas)
        $practice = Practice::with(['participants' => function ($query) {
            $query->select('users.id', 'users.name', 'participation.status');
        }])->findOrFail($id);

        // Pārveido datus vienkāršā masīvā priekš JavaScript
        $participants = $practice->participants->map(function ($user) {
            return [
                'name' => $user->name,
                'status' => $user->pivot->status,
            ];
        });

        // Atdod sarakstu JSON formātā
        return response()->json($participants);
    }

    public function show(Practice $practice)
    {
        // Ielādē dalībniekus konkrētajam treniņam
        $practice->load('participants');

        // Paņem visus lietotājus, kas reģistrēti sistēmā
        $allUsers = User::all();

        // Izvelk ID tiem spēlētājiem, kas jau ir pieteikušies
        $registeredUserIds = $practice->participants->pluck('id')->toArray();

        // Atlasa tikai tos lietotājus, kas vēl nav paspējuši atzīmēties
        $unmarkedUsers = $allUsers->filter(function ($user) use ($registeredUserIds) {
            return !in_array($user->id, $registeredUserIds);
        });

        // Atver trenera skatu, iedodot līdzi treniņa datus un neatzīmētos lietotājus
        return view('dashboard.coach.show', compact('practice', 'unmarkedUsers')); 
    }
}