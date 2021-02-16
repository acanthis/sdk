<?php

namespace Eds\CustomFields\Form\Type;

use Eds\CustomFields\Form\Attribute\ClientDataListAttributeForm;
use Eds\CustomFields\Form\CustomFiledBaseForm;
use Eds\CustomFields\Value\CustomFieldType;

class ClientDataListTypeForm extends CustomFiledBaseForm
{
    public function __construct()
    {
        parent::__construct();

        $this
            ->addElement(new ClientDataListAttributeForm())
        ;
    }

    public function canBeUsed(array $array): bool
    {
        return CustomFieldType::TYPE_CLIENT_LIST === $array['type'];
    }
}
