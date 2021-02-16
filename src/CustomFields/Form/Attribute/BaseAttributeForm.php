<?php

namespace Eds\CustomFields\Form\Attribute;

use Nrg\Form\Form;

class BaseAttributeForm extends Form
{
    public function __construct()
    {
        $this->setName('attributes');
    }
}
