<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClockColors extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that aren't included in json.
     *
     * @var array
     */
    protected $hidden = ['clock'];

    /**
     * The clock this belongs to
     */
    public function clock(): BelongsTo
    {
        return $this->belongsTo(Clock::class);
    }
}
