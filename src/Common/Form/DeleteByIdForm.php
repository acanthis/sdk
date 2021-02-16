<?php

namespace Eds\Common\Form;

use Nrg\Data\Form\EqualConditionForm;
use Nrg\Data\Form\ListForm;
use Nrg\Form\Validator\UuidValidator;

class DeleteByIdForm extends ListForm
{
    public function __construct()
    {
        parent::__construct();

        $this
            ->addConditionForm(
                (new EqualConditionForm())
                    ->addValueValidator(new UuidValidator())
                    ->setFilterableFields(['id'])
            )
        ;
    }
}
