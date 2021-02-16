<?php

namespace Nrg\Form\Abstraction;

interface FilterInterface
{
    public function apply(ElementInterface $element): void;
}
