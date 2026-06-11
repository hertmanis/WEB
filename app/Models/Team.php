<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Team extends Model
{
    use HasFactory;

    // Define which attributes are mass assignable
    protected $fillable = ['name', 'team_code'];

    /**
     * Automatically generate a unique team_code when creating a team.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($team) {
            $team->team_code = strtoupper(Str::random(6)); // Generates a 6-character uppercase code
        });
    }

    /**
     * Get all users that belong to this team.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
