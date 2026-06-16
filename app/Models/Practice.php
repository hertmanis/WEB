<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; 
use App\Models\Team; 

class Practice extends Model
{
    use HasFactory;

    // lauki kurus var aizpildit masveida
    protected $fillable = [
        'team_id',
        'coach_id',
        'title',
        'description',
        'scheduled_at',
        'type',
    ];

    // Datu tipu kastinga masīvs
    protected $casts = [
        'scheduled_at' => 'datetime', // Pārvērš scheduled_at lauku par datuma un laika objektu
    ];

    // Relācija Katram treniņam ir viens konkrēts treneris no lietotāju tabulas
    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    // Relācija Katrs treniņš pieder vienai konkrētai komandai
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    // Relācija Daudzi pret daudziem ar lietotājiem caur starptabulu
    public function participants()
    {
        // Savieno treniņu ar spēlētājiem izmantojot participations tabulu
        // Ar withPivot paņem līdzi pieteikšanās statusu būs vai nebūs
        return $this->belongsToMany(User::class, 'participations', 'practice_id', 'user_id')
                    ->withPivot('status');
    }
}