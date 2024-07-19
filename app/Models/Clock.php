<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clock extends Model
{
    use HasFactory;
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['alarm_count', 'clock_colors_count', 'username'];

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

    /**
     * Get the amount of alarms
     */
    public function alarmCount() : Attribute
    {
        return Attribute::make(
            get: fn () => $this->alarms()->count()
        );
    }

    /**
     * Get the amount of clockColors
     */
    public function clockColorsCount() : Attribute
    {
        return Attribute::make(
            get: fn () => $this->clockColors()->count()
        );
    }

    /**
     * Get the username 
     */
    public function username() : Attribute
    {
        return Attribute::make(
            get: fn () => $this->user()->first()->name
        );
    }
}
