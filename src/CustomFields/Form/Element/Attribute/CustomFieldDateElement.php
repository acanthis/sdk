<?php

namespace Eds\CustomFields\Form\Element\Attribute;

use Nrg\Form\Element;
use Nrg\Form\Validator\DateTimeValidator;

class CustomFieldDateElement extends Element
{
    public function __construct()
    {
        $this->addValidator(new DateTimeValidator());
    }
}