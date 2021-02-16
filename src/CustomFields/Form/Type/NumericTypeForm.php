<?php

namespace Eds\CustomFields\Form\Type;

use Eds\CustomFields\Form\Attribute\NumericAttributeForm;
use Eds\CustomFields\Form\CustomFiledBaseForm;
use Eds\CustomFields\Value\CustomFieldType;

class NumericTypeForm extends CustomFiledBaseForm
{
    public function __construct()
    {
        parent::__construct();

        $this
            ->addElement(new NumericAttributeForm())
        ;
    }

    public function canBeUsed(array $array): bool
    {
        return CustomFieldType::TYPE_NUMERIC === $array['type'];
    }
}
