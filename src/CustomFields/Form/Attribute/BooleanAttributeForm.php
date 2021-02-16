<?php

namespace Eds\CustomFields\Form\Attribute;

use Eds\CustomFields\Form\Element\Type\Boolean\DefaultValueElement;

class BooleanAttributeForm extends BaseAttributeForm
{
    public function __construct()
    {
        parent::__construct();

        $this->addElement(new DefaultValueElement());
    }
}
