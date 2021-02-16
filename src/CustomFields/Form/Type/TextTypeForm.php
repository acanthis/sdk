<?php

namespace Eds\CustomFields\Form\Type;

use Eds\CustomFields\Form\Attribute\TextAttributeForm;
use Eds\CustomFields\Form\CustomFiledBaseForm;
use Eds\CustomFields\Value\CustomFieldType;

class TextTypeForm extends CustomFiledBaseForm
{
    public function __construct()
    {
        parent::__construct();

        $this
            ->addElement(new TextAttributeForm())
        ;
    }

    public function canBeUsed(array $array): bool
    {
        return CustomFieldType::TYPE_TEXT === $array['type'];
    }
}
