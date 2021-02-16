<?php

namespace Eds\CustomFields\Form\Attribute;

use Eds\CustomFields\Form\Element\Type\Numeric\DefaultValueElement;
use Eds\CustomFields\Form\Element\Type\Numeric\MaxElement;
use Eds\CustomFields\Form\Element\Type\Numeric\MinElement;

class NumericAttributeForm extends BaseAttributeForm
{
    public function __construct()
    {
        parent::__construct();

        $this
            ->addElement(new MinElement())
            ->addElement(new MaxElement())
            ->addElement(new DefaultValueElement())
        ;
    }
}
