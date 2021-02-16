<?php

namespace Eds\CustomFields\Form\Attribute;

use Eds\CustomFields\Form\Element\Type\ClientDataList\RelationIdElement;

class ClientDataListAttributeForm extends BaseAttributeForm
{
    public function __construct()
    {
        parent::__construct();

        $this->addElement(
            (new RelationIdElement())
                ->isRequired()
        );
    }
}
