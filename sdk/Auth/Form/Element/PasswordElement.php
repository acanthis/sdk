<?php

namespace Nrg\Auth\Form\Element;

use Nrg\Form\Element;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\LengthStringRangeValidator;
use Nrg\Form\Validator\StringValidator;

class PasswordElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('password')
            ->isRequired()
            ->addFilter(new TrimFilter())
            ->addValidator(new StringValidator())
            ->addValidator(
                (new LengthStringRangeValidator())
                    ->setMinLength(6) // todo: move to .env
                    ->setMaxLength(32) // todo: move to .env
            );
    }
}
