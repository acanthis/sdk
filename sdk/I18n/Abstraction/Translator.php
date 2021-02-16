<?php

namespace Nrg\I18n\Abstraction;

use Nrg\I18n\Value\Message;
use ReflectionException;

interface Translator
{
    /**
     * @param Message|string $message
     *
     * @throws ReflectionException
     */
    public function translate($message): string;

    public function addDictionary(string $class): void;
}
