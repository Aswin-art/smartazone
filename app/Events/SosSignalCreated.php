<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class SosSignalCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sosData;

    public function __construct(array $sosData)
    {
        $this->sosData = $sosData;
    }

    public function broadcastOn()
    {
        return new Channel('mountain-sos.'.$this->sosData['mountain_id']);
    }

    public function broadcastAs()
    {
        return 'sos.created';
    }
}
