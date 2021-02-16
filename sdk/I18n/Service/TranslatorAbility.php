<?php

namespace Nrg\I18n\Service;

use Nrg\I18n\Abstraction\Translator;
use ReflectionException;

trait TranslatorAbility
{
    private Translator $translator;

    /**
     * @param $message
     *
     * @throws ReflectionException
     */
    public function t($message): string
    {
        return null === $this->translator ? $message : $this->translator->translate($message);
    }

    public function addDictionary(string $class): void
    {
        if (null !== $this->translator) {
            $this->translator->addDictionary($class);
        }
    }
}
