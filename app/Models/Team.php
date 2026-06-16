<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Team extends Model
{
    use HasFactory;

    // Lauki kurus drīkst aizpildīt masveidā
    protected $fillable = ['name', 'team_code'];

    /**
        * Automātiski ģenerē unikālu komandas kodu pirms komandas izveides datubāzē
     */
    protected static function boot()
    {
        parent::boot();

        // Notikums kas izpildās tieši pirms jauna ieraksta saglabāšanas datubāzē
        static::creating(function ($team) {
            // Automātiski uzģenerē unikālu 6 zīmju kodu ar lielajiem burtiem
            $team->team_code = strtoupper(Str::random(6)); 
        });
    }

    /**
     * Relācija Vienai komandai var piederēt daudzi lietotāji spēlētāji un treneri
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}