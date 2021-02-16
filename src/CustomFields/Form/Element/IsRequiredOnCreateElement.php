<?php

namespace Eds\CustomFields\Form\Element;

use Nrg\Form\Element;
use Nrg\Form\Validator\BooleanValidator;

class IsRequiredOnCreateElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('isRequiredOnCreate')
            ->addValidator(new BooleanValidator())
        ;
    }
}
