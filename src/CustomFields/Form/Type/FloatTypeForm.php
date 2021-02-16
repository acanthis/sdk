<?php

namespace Eds\CustomFields\Form\Type;

use Eds\CustomFields\Form\Attribute\FloatAttributeForm;
use Eds\CustomFields\Form\CustomFiledBaseForm;
use Eds\CustomFields\Value\CustomFieldType;

class FloatTypeForm extends CustomFiledBaseForm
{
    public function __construct()
    {
        parent::__construct();

        $this
            ->addElement(new FloatAttributeForm())
        ;
    }

    public function canBeUsed(array $array): bool
    {
        return CustomFieldType::TYPE_FLOAT === $array['type'];
    }
}
