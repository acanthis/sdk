<?php

namespace Eds\Common\Action;

use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Value\HttpStatus;

class ApiStatusAction
{
    public function onNext(HttpExchangeEvent $event)
    {
        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(['Status' => 'Ok'])
        ;
    }
}
