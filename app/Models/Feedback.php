<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    use HasFactory;

    // Norāda laukus kurus ir atļauts saglabāt un mainīt sistēmā
    protected $fillable = ['user_id', 'practice_id', 'comments', 'rating'];

    // Relācija Katra atsauksme pieder vienam konkrētam lietotājam
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relācija Katra atsauksme pieder vienam konkrētam treniņam vai spēlei
    public function practice(): BelongsTo
    {
        return $this->belongsTo(Practice::class);
    }
}