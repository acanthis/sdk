<?php

namespace Eds\CustomFields\Form\Type;

use Eds\CustomFields\Form\Attribute\IntegerAttributeForm;
use Eds\CustomFields\Form\CustomFiledBaseForm;
use Eds\CustomFields\Value\CustomFieldType;

class IntegerTypeForm extends CustomFiledBaseForm
{
    public function __construct()
    {
        parent::__construct();

        $this
            ->addElement(new IntegerAttributeForm())
        ;
    }

    public function canBeUsed(array $array): bool
    {
        return CustomFieldType::TYPE_INTEGER === $array['type'];
    }
}
