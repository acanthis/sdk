<?php

namespace Eds\CustomFields\Form\Attribute;

use Eds\CustomFields\Form\Element\Type\Float\DefaultValueElement;
use Eds\CustomFields\Form\Element\Type\Float\MaxElement;
use Eds\CustomFields\Form\Element\Type\Float\MinElement;

class FloatAttributeForm extends BaseAttributeForm
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
