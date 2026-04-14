<?php

namespace App\Listeners;

use App\Events\SmsSendingEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSmsListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SmsSendingEvent $event): void
    {
        try {
            // Send a message using the primary device.
            $msg = sendSingleMessage($event->to, $event->message );

            print_r($msg);

            echo "Successfully sent a message.";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
