<?php

namespace Nrg\Form\Helper;

trait NameTrait
{
    private ?string $name = null;

    public function getName(): string
    {
        return $this->name;
    }

    public function hasName(): bool
    {
        return null !== $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
