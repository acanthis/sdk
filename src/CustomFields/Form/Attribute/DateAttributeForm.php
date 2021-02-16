<?php

namespace Eds\CustomFields\Form\Attribute;

use Eds\CustomFields\Form\Element\Type\Date\DefaultValueElement;
use Eds\CustomFields\Form\Element\Type\Date\MaxElement;
use Eds\CustomFields\Form\Element\Type\Date\MinElement;

class DateAttributeForm extends BaseAttributeForm
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
