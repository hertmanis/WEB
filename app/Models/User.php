<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Lauki kurus drīkst masveidā aizpildīt no formām reģistrācijā vai profilā
    protected $fillable = [
        'name',
        'email',
        'password',
        'team_id',
        'role',
    ];

    // Sensitīvie lauki kas tiks automātiski paslēpti kad datus pārvērš par JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Datu tipu kastinga masīvs automātiskai datu pārveidošanai
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Automātiski nošifrē paroli kad tā tiek saglabāta
        'role' => 'boolean',    // Pārveido lomas lauku par True vai False
    ];

    // Relācija Katrs lietotājs pieder vienai konkrētai komandai
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    // Relācija Viens lietotājs var uzrakstīt daudzas atsauksmes
    public function feedback(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    // Relācija Daudzi pret daudziem ar treniņiem un spēlēm
    public function practices()
    {
        // Savieno lietotāju ar aktivitātēm un paņem līdzi statusu no starptabulas
        return $this->belongsToMany(Practice::class, 'practice_user')
                    ->withPivot('status')
                    ->withTimestamps();
    }
}