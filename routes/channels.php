<?php

use App\Events\ClockUpdated;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('clock.{id}', ClockUpdated::class);
