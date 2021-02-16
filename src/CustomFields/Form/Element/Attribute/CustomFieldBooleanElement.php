<?php

namespace Eds\CustomFields\Form\Element\Attribute;

use Nrg\Form\Element;
use Nrg\Form\Validator\BooleanValidator;

class CustomFieldBooleanElement extends Element
{
    public function __construct()
    {
        $this->addValidator(new BooleanValidator());
    }
}