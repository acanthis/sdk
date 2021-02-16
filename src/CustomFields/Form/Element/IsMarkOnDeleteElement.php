<?php

namespace Eds\CustomFields\Form\Element;

use Nrg\Form\Element;
use Nrg\Form\Validator\BooleanValidator;

class IsMarkOnDeleteElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('isMarkOnDelete')
            ->addValidator(new BooleanValidator())
        ;
    }
}
