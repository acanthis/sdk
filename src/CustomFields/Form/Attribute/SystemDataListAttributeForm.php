<?php

namespace Eds\CustomFields\Form\Attribute;

use Eds\CustomFields\Form\Element\Type\SystemDataList\RelationNameElement;

class SystemDataListAttributeForm extends BaseAttributeForm
{
    public function __construct()
    {
        parent::__construct();

        $this->addElement(
            (new RelationNameElement())
                ->isRequired()
        );
    }
}
