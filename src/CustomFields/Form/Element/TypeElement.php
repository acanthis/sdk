<?php

namespace Eds\CustomFields\Form\Element;

use Eds\CustomFields\Value\CustomFieldType;
use Nrg\Form\Element;
use Nrg\Form\Validator\InArrayValidator;

class TypeElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('type')
            ->addValidator(
                (new InArrayValidator())
                    ->setHaystack(CustomFieldType::CUSTOM_FIELD_TYPE_LIST)
            )
        ;
    }
}
