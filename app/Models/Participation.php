<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    use HasFactory;

    // Lauki kurus drīkst masveidā aizpildīt un saglabāt datubāzē
    protected $fillable = ['practice_id', 'user_id', 'status'];

    // Relācija Katrs pieteikums pieder vienam konkrētam treniņam
    public function practice()
    {
        return $this->belongsTo(Practice::class);
    }

    // Relācija Katrs pieteikums pieder vienam konkrētam lietotājam
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}