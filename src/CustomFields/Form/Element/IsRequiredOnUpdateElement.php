<?php

namespace Eds\CustomFields\Form\Element;

use Nrg\Form\Element;
use Nrg\Form\Validator\BooleanValidator;

class IsRequiredOnUpdateElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('isRequiredOnUpdate')
            ->addValidator(new BooleanValidator())
        ;
    }
}
