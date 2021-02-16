<?php

namespace Nrg\Form\Helper;

trait IsEmptyTrait
{
    private function isEmpty($value): bool
    {
        return null === $value || '' === $value;
    }
}
