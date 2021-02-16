<?php

namespace Nrg\I18n\Value;

class CompositeMessage extends Message
{
    private array $messages;

    private string $separator = ', ';

    public function __construct(Message ...$messages)
    {
        parent::__construct();
        $this->messages = $messages;
    }

    /** @return Message[] */
    public function getMessages(): array
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        $this->messages[] = $message;

        return $this;
    }

    public function setSeparator(string $separator): self
    {
        $this->separator = $separator;

        return $this;
    }

    public function getText(): string
    {
        $texts = [];

        foreach ($this->getMessages() as $message) {
            $texts[] = $message->getText();
        }

        return implode($this->separator, $texts);
    }

    public function getParams(): array
    {
        $params = [];

        foreach ($this->getMessages() as $message) {
            $params[] = $message->getParams();
        }

        return array_merge(...$params);
    }
}
