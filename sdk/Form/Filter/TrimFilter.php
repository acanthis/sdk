<?php

namespace Nrg\Form\Filter;

use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\FilterInterface;

class TrimFilter implements FilterInterface
{
    public function apply(ElementInterface $element): void
    {
        if ($element->hasValue() && is_string($element->getValue())) {
            $element->setValue(trim($element->getValue()));
        }
    }
}
