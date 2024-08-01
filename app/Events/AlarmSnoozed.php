<?php

namespace App\Events;

use App\Models\Alarm;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AlarmSnoozed implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $alarm;
    public $count;

    /**
     * Create a new event instance.
     */
    public function __construct(Alarm $alarm, int $count)
    {
        $this->alarm = $alarm;
        $this->count = $count;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel("clock.{$this->alarm->clock->id}"),
        ];
    }
}
