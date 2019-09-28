<?php

namespace App\Listeners;

use App\Events\CommodityView;

class CommodityViewListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CommodityView  $event
     * @return void
     */
    public function handle(CommodityView $event)
    {
        $event->commodity->count_view = $event->commodity->count_view + 1;
        $event->commodity->save();
    }
}
