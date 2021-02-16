<?php

namespace Nrg\Di\Abstraction;

use ReflectionException;

interface Injector
{
    /**
     * Creates an object using the list of services definitions.
     *
     * @throws ReflectionException
     */
    public function createObject(string $class, array $args = []);

    /**
     * @param $definition
     *
     * @throws ReflectionException
     *
     * @return mixed|object
     */
    public function createObjectByDefinition($definition);

    /**
     * Invokes an object method with arguments.
     *
     * @param object $object
     *
     * @throws ReflectionException
     *
     * @return mixed method result
     */
    public function invokeMethod($object, string $name, array $args = []);

    /**
     * Invokes a function with arguments.
     *
     * @throws ReflectionException
     *
     * @return mixed function result
     */
    public function invokeFunction(callable $function, array $args = []);

    /**
     * Sets a service definition.
     *
     * @param array|callable|object|string $definition
     */
    public function setService(string $interface, $definition): Injector;

    /**
     * Returns a service object or null if service was not found.
     *
     * @throws ReflectionException
     *
     * @return null|object
     */
    public function getService(string $interface);

    /**
     * Loads services definitions.
     */
    public function loadServices(array $definitions): Injector;
}
