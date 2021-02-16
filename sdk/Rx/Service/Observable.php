<?php

namespace Nrg\Rx\Service;

use SplObjectStorage;
use Throwable;

class Observable
{
    private $storage;

    public function __construct()
    {
        $this->storage = new SplObjectStorage();
    }

    public function addObserver(object $observer): Observable
    {
        $this->storage->attach($observer);

        return $this;
    }

    public function removeObserver(object $observer): Observable
    {
        $this->storage->detach($observer);

        return $this;
    }

    public function notifyObservers(object $event)
    {
        try {
            foreach ($this->storage as $observer) {
                if (method_exists($observer, 'onNext')) {
                    $observer->onNext($event);
                }
            }
            foreach ($this->storage as $observer) {
                if (method_exists($observer, 'onComplete')) {
                    $observer->onComplete();
                }
            }
        } catch (Throwable $throwable) {
            foreach ($this->storage as $observer) {
                if (method_exists($observer, 'onError')) {
                    $observer->onError($throwable, $event);
                }
            }
        }
    }
}
