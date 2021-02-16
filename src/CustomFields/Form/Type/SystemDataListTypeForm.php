<?php

namespace Eds\CustomFields\Form\Type;

use Eds\CustomFields\Form\Attribute\SystemDataListAttributeForm;
use Eds\CustomFields\Form\CustomFiledBaseForm;
use Eds\CustomFields\Value\CustomFieldType;

class SystemDataListTypeForm extends CustomFiledBaseForm
{
    public function __construct()
    {
        parent::__construct();
        $this
            ->addElement(new SystemDataListAttributeForm())
        ;
    }

    public function canBeUsed(array $array): bool
    {
        return CustomFieldType::TYPE_SYSTEM_LIST === $array['type'];
    }
}
