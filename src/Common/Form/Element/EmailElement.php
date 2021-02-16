<?php

namespace Eds\Common\Form\Element;

use Nrg\Form\Element;
use Nrg\Form\Filter\DefaultNullFilter;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\EmailValidator;
use Nrg\Form\Validator\LengthStringRangeValidator;

class EmailElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('email')
            ->addFilter(new TrimFilter())
            ->addFilter(new DefaultNullFilter())
            ->addValidator(new EmailValidator())
            ->addValidator(
                (new LengthStringRangeValidator())
                    ->setMinLength(5)
                    ->setMaxLength(150)
            )
        ;
    }
}
