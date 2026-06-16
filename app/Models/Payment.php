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
        'team_id',   
        'paid',      
    ];
    
    // Relācija Katrs maksājums ir piesaistīts vienai konkrētai komandai
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    
    // Relācija Katru maksājumu ir izveidojis kāds konkrēts lietotājs piemēram treneris
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}