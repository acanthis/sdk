<?php

namespace Nrg\Utility\Action;

use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Value\HttpStatus;
use Nrg\Utility\Abstraction\Config;

class ConfigAction
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Returns app config.
     */
    public function onNext(HttpExchangeEvent $event): void
    {
        $event->getResponse()
            ->setBody($this->config)
            ->setStatusCode(HttpStatus::OK)
        ;
    }
}
