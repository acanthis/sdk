<?php

namespace Nrg\Auth\Form\Element;

use Nrg\Form\Element;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\EmailValidator;
use Nrg\Form\Validator\LengthStringRangeValidator;
use Nrg\Form\Validator\StringValidator;

class EmailElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('email')
            ->isRequired()
            ->addFilter(new TrimFilter())
            ->addValidator(new StringValidator())
            ->addValidator(
                (new LengthStringRangeValidator())
                    ->setMinLength(6)
                    ->setMaxLength(255)
            )
            ->addValidator(new EmailValidator())
        ;
    }
}
