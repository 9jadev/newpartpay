<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
// $newinvoice


class NewInvoiceCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $newinvoice;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($newinvoice)
    {
        $this->newinvoice = $newinvoice;
        Log::info('Showing fired for user:'. $newinvoice);
    }

}
