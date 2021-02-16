<?php

namespace Nrg\Form\Abstraction;

interface ValidatorInterface
{
    public function isValid(ElementInterface $element): bool;

    public function getErrors();
}
