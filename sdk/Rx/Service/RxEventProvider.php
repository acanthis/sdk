<?php

namespace Nrg\Rx\Service;

use LogicException;
use Nrg\Di\Abstraction\Injector;
use Nrg\Rx\Abstraction\EventProvider;
use Nrg\Utility\Abstraction\Settings;

class RxEventProvider implements EventProvider
{
    private array $observables = [];

    private Injector $injector;

    public function __construct(Injector $injector, Settings $settings)
    {
        $this->injector = $injector;

        foreach ($settings->getEvents() as $event => $observers) {
            $this->on($event, $observers);
        }
    }

    public function trigger($event)
    {
        $eventName = get_class($event);

        if (!$this->hasObservable($eventName)) {
            throw new LogicException("Event '{$eventName}' is not registered");
        }

        $observable = $this->getObservable($eventName);

        $observable->notifyObservers($event);
    }

    /**
     * Adds the observers for the event.
     */
    private function on(string $event, array $observers): void
    {
        $this->observables[$event] = $observers;
    }

    /**
     * Checks if the observable corresponding to the event exists.
     */
    private function hasObservable(string $event): bool
    {
        return isset($this->observables[$event]);
    }

    /**
     * Returns the observable corresponding to the event.
     */
    private function getObservable(string $event): Observable
    {
        if (is_object($this->observables[$event])) {
            return $this->observables[$event];
        }

        $observable = new Observable();
        foreach ($this->observables[$event] as $index => $observer) {
            $observer = $this->injector->createObjectByDefinition($observer);
            $observable->addObserver($observer);
        }
        $this->observables[$event] = $observable;

        return $this->observables[$event];
    }
}
