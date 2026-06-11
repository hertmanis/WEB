<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'description',
        'created_by',
        'team_id',   // Pievieno team_id, lai varētu masveidā aizpildīt
        'paid',      // Pievieno paid, lai varētu atzīmēt apmaksu
    ];
    
    // Vari pievienot arī attiecības, ja vajadzēs:
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
