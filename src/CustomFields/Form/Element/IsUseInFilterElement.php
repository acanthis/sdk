<?php

namespace Eds\CustomFields\Form\Element;

use Nrg\Form\Element;
use Nrg\Form\Validator\BooleanValidator;

class IsUseInFilterElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('isUseInFilter')
            ->addValidator(new BooleanValidator())
        ;
    }
}
