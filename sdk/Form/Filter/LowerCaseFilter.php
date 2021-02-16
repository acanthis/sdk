<?php

namespace Nrg\Form\Filter;

use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\FilterInterface;

class LowerCaseFilter implements FilterInterface
{
    public function apply(ElementInterface $element): void
    {
        if ($element->hasValue() && is_string($element->getValue())) {
            $element->setValue(strtolower($element->getValue()));
        }
    }
}
