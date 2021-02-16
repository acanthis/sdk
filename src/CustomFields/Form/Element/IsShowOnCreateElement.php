<?php

namespace Eds\CustomFields\Form\Element;

use Nrg\Form\Element;
use Nrg\Form\Validator\BooleanValidator;

class IsShowOnCreateElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('isShowOnCreate')
            ->addValidator(new BooleanValidator())
        ;
    }
}
