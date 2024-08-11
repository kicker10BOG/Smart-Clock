<?php

namespace App\Events;

use App\Models\ClockColors;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ColorEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $color;
    public $color_id;
    public $clock_id;
    public $type;
    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct(ClockColors $color = null, string $type='update', int $color_id = null, int $clock_id = null)
    {
        $this->color = $color;
        $this->color_id = $color_id;
        $this->type = $type;
        $this->clock_id = $color ? $color->clock->id : $clock_id;
        switch ($type) {
            case 'create':
                $this->message = "Color Change Added";
                break;
            case 'update':
                $this->message = "Color Change Updated";
                break;
            case 'enable':
                $this->message = "Color Change Enabled";
                break;
            case 'disable':
                $this->message = "Color Change Disabled";
                break;
            case 'delete':
                $this->message = "Color Change Removed";
                break;
            
            default:
                # code...
                break;
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel("clock.{$this->clock_id}"),
        ];
    }
}
