<?php

namespace App\Observers;

use App\Events\SmsSendingEvent;
use App\Models\Deposite;

class DepositeObserver
{
    /**
     * Handle the Deposite "created" event.
     */
    public function created(Deposite $deposite): void
    {
        $message = "Hi {$deposite->guest->name},\n We have Received Rs.{$deposite->amount} ";
        event(new SmsSendingEvent($deposite->guest->mobile, $message));
    }

    /**
     * Handle the Deposite "updated" event.
     */
    public function updated(Deposite $deposite): void
    {
        //
    }

    /**
     * Handle the Deposite "deleted" event.
     */
    public function deleted(Deposite $deposite): void
    {
        //
    }

    /**
     * Handle the Deposite "restored" event.
     */
    public function restored(Deposite $deposite): void
    {
        //
    }

    /**
     * Handle the Deposite "force deleted" event.
     */
    public function forceDeleted(Deposite $deposite): void
    {
        //
    }
}
