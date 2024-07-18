<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clock extends Model
{
    use HasFactory;

    /**
     * The user this belongs to
     */
    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the Alarms this Clock owns
     */
    public function alarms(): HasMany
    {
        return $this->hasMany(Alarm::class);
    }

    /**
     * Get the ClockColors this Clock owns
     */
    public function clockColors(): HasMany
    {
        return $this->hasMany(ClockColors::class);
    }
}
