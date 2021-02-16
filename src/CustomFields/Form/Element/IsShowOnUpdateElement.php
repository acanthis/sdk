<?php

namespace Eds\CustomFields\Form\Element;

use Nrg\Form\Element;
use Nrg\Form\Validator\BooleanValidator;

class IsShowOnUpdateElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('isShowOnUpdate')
            ->addValidator(new BooleanValidator())
        ;
    }
}
