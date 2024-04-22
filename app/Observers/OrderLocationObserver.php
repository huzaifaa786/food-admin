<?php

namespace App\Observers;

use App\Events\OrderLocationChangeEvent;
use App\Models\OrderLocation;

class OrderLocationObserver
{
    /**
     * Handle the OrderLocation "created" event.
     */
    public function created(OrderLocation $orderLocation): void
    {
        broadcast(new OrderLocationChangeEvent($orderLocation));
    }

    /**
     * Handle the OrderLocation "updated" event.
     */
    public function updated(OrderLocation $orderLocation): void
    {
        broadcast(new OrderLocationChangeEvent($orderLocation));
    }

    /**
     * Handle the OrderLocation "deleted" event.
     */
    public function deleted(OrderLocation $orderLocation): void
    {
        //
    }

    /**
     * Handle the OrderLocation "restored" event.
     */
    public function restored(OrderLocation $orderLocation): void
    {
        //
    }

    /**
     * Handle the OrderLocation "force deleted" event.
     */
    public function forceDeleted(OrderLocation $orderLocation): void
    {
        //
    }
}
