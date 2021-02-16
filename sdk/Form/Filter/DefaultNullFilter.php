<?php

namespace Nrg\Form\Filter;

use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\FilterInterface;

class DefaultNullFilter implements FilterInterface
{
    public function apply(ElementInterface $element): void
    {
        if ($element->hasValue() && $element->hasEmptyValue()) {
            $element->setValue(null);
        }
    }
}
