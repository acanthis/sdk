<?php

namespace Eds\Common\Form\Element;

use Nrg\Form\Element;
use Nrg\Form\Validator\BooleanValidator;

class IsDefaultElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('isDefault')
            ->addValidator(new BooleanValidator())
        ;
    }
}
