<?php

namespace Eds\CustomFields\Form\Element\Attribute;

use Nrg\Form\Element;
use Nrg\Form\Validator\UuidValidator;

class CustomFieldClientListElement extends Element
{
    public function __construct()
    {
        $this->addValidator(new UuidValidator());
    }
}