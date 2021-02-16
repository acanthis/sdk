<?php

namespace Eds\CustomFields\Form\Type;

use Eds\CustomFields\Form\Attribute\DateAttributeForm;
use Eds\CustomFields\Form\CustomFiledBaseForm;
use Eds\CustomFields\Value\CustomFieldType;

class DateTypeForm extends CustomFiledBaseForm
{
    public function __construct()
    {
        parent::__construct();

        $this
            ->addElement(new DateAttributeForm())
        ;
    }

    public function canBeUsed(array $array): bool
    {
        return CustomFieldType::TYPE_DATE === $array['type'];
    }
}
