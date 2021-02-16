<?php

namespace Nrg\Rx\Abstraction;

interface EventProvider
{
    /**
     * Trigger the event.
     * Notifies observers about the event.
     */
    public function trigger(object $event);
}
