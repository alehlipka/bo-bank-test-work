<?php

namespace App\Events;

use App\Models\Transfer;
use Illuminate\Queue\SerializesModels;

class TransferCreatedEvent
{
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Transfer $transfer)
    {
    }
}
