<?php

namespace Eds\CustomFields\Form\Element;

use Nrg\Form\Element;
use Nrg\Form\Validator\BooleanValidator;

class IsUniqueElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('isUnique')
            ->addValidator(new BooleanValidator())
        ;
    }
}
