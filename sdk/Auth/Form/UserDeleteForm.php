<?php

namespace Nrg\Auth\Form;

use Nrg\Data\Dto\Collection\AllowedFieldsCollection;
use Nrg\Data\Form\ListForm;
use Nrg\Form\Validator\UuidValidator;

class UserDeleteForm extends ListForm
{
    protected function getFilterAllowedFields(): AllowedFieldsCollection
    {
        return (new AllowedFieldsCollection())
            ->add('id', new UuidValidator())
            ->add('createdAt')
        ;
    }
}
