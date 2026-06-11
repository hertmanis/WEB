<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Svarīgi: Pārliecinieties, ka šis ir importēts!
use App\Models\Team; // Svarīgi: Pārliecinieties, ka šis ir importēts, ja izmantojat team() relāciju!

class Practice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'team_id',
        'coach_id',
        'title',
        'description',
        'scheduled_at',
        'type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'scheduled_at' => 'datetime', // Pārliecinieties, ka datums tiek apstrādāts kā datuma/laika objekts
    ];

    /**
     * Get the coach that owns the practice.
     */
    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    /**
     * Get the team that the practice belongs to.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the participants for the practice.
     * This establishes a many-to-many relationship with the User model
     * through the 'participations' pivot table, including the 'status' column.
     */
    public function participants()
    {
        // 1. parametrs: User::class - modelis, ar kuru tiek veidota relācija
        // 2. parametrs: 'participations' - pivot tabulas nosaukums
        // 3. parametrs: 'practice_id' - pašreizējā modeļa (Practice) ārējā atslēga pivot tabulā
        // 4. parametrs: 'user_id' - saistītā modeļa (User) ārējā atslēga pivot tabulā
        // withPivot('status') - nodrošina, ka 'status' kolonna no pivot tabulas ir pieejama
        return $this->belongsToMany(User::class, 'participations', 'practice_id', 'user_id')
                    ->withPivot('status');
    }
}