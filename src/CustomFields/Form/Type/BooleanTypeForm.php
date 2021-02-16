<?php

namespace Eds\CustomFields\Form\Type;

use Eds\CustomFields\Form\Attribute\BooleanAttributeForm;
use Eds\CustomFields\Form\CustomFiledBaseForm;
use Eds\CustomFields\Value\CustomFieldType;

class BooleanTypeForm extends CustomFiledBaseForm
{
    public function __construct()
    {
        parent::__construct();

        $this
            ->addElement(new BooleanAttributeForm())
        ;
    }

    public function canBeUsed(array $array): bool
    {
        return CustomFieldType::TYPE_BOOLEAN === $array['type'];
    }
}
