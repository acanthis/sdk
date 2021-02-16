<?php

namespace Nrg\Form\Helper;

use Nrg\Form\Abstraction\ElementInterface;

trait ParentTrait
{
    private ?ElementInterface $parent = null;

    public function setParent(ElementInterface $parent)
    {
        $this->parent = $parent;
    }

    public function hasParent(): bool
    {
        return null !== $this->parent;
    }

    public function getParent(): ElementInterface
    {
        return $this->parent;
    }
}
