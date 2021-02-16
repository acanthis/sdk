<?php

namespace Eds\CustomFields\Form\Attribute;

use Eds\CustomFields\Form\Element\Type\Text\DefaultValueElement;
use Eds\CustomFields\Form\Element\Type\Text\MaxLengthElement;
use Eds\CustomFields\Form\Element\Type\Text\MinLengthElement;

class TextAttributeForm extends BaseAttributeForm
{
    public function __construct()
    {
        parent::__construct();

        $this
            ->addElement(new MinLengthElement())
            ->addElement(new MaxLengthElement())
            ->addElement(new DefaultValueElement())
        ;
    }
}
