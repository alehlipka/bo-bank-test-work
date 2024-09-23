<?php

namespace App\Listeners;

use App\Events\TransferCreatedEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransferCreatedListener implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(TransferCreatedEvent $event)
    {
        Log::channel('transfer')
            ->info('Processing transfer', ['transfer' => $event->transfer]);
    }
}
