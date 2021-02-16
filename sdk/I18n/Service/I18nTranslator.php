<?php

namespace Nrg\I18n\Service;

use Nrg\Di\Abstraction\Injector;
use Nrg\I18n\Abstraction\Dictionary;
use Nrg\I18n\Abstraction\Translator;
use Nrg\I18n\Value\CompositeMessage;
use Nrg\I18n\Value\Message;
use ReflectionException;

class I18nTranslator implements Translator
{
    private Injector $injector;

    private ?string $locale;

    private array $dictionaries = [];

    public function __construct(Injector $injector, string $locale = null)
    {
        $this->injector = $injector;
        $this->locale = $locale;
    }

    public function translate($message): string
    {
        if (null === $this->locale) {
            return $message;
        }

        return $message instanceof Message ?
            $this->translateMessage($message) :
            $this->translateText($message);
    }

    public function addDictionary(string $class): void
    {
        if (!$this->hasDictionary($class)) {
            $this->dictionaries[$class] = null;
        }
    }

    private function hasDictionary(string $class): bool
    {
        return array_key_exists($class, $this->dictionaries);
    }

    /**
     * @throws ReflectionException
     */
    private function getDictionary(string $class): Dictionary
    {
        if (null === $this->dictionaries[$class]) {
            $this->dictionaries[$class] = $this->injector->createObject($class);
        }

        return $this->dictionaries[$class];
    }

    /**
     * @throws ReflectionException
     */
    private function translateMessage(Message $message): Message
    {
        return $message instanceof CompositeMessage ?
            $this->translateCompositeMessage($message) :
            new Message($this->translateText($message->getText()), $message->getParams());
    }

    /**
     * @throws ReflectionException
     */
    private function translateCompositeMessage(CompositeMessage $message): CompositeMessage
    {
        $compositeMessage = new CompositeMessage();
        foreach ($message->getMessages() as $subMessage) {
            $compositeMessage->addMessage($this->translateMessage($subMessage));
        }

        return $compositeMessage;
    }

    /**
     * @throws ReflectionException
     */
    private function translateText(string $text): string
    {
        foreach ($this->dictionaries as $class => $dictionary) {
            $result = $this->getDictionary($class)->translate($text, $this->locale);
            if ($text !== $result) {
                return $result;
            }
        }

        return $text;
    }
}
