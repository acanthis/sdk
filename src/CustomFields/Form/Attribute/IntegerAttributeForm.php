<?php

namespace Eds\CustomFields\Form\Attribute;

use Eds\CustomFields\Form\Element\Type\Integer\DefaultValueElement;
use Eds\CustomFields\Form\Element\Type\Integer\MaxElement;
use Eds\CustomFields\Form\Element\Type\Integer\MinElement;

class IntegerAttributeForm extends BaseAttributeForm
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
