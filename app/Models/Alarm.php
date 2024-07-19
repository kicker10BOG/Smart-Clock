<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alarm extends Model
{
    use HasFactory;

    /**
     * The clock this belongs to
     */
    public function clock(): BelongsTo
    {
        return $this->belongsTo(Clock::class);
    }
}