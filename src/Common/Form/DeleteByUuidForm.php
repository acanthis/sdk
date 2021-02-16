<?php

namespace Eds\Common\Form;

use Nrg\Data\Form\InConditionForm;
use Nrg\Data\Form\ListForm;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\ArrayValidator;
use Nrg\Form\Validator\UuidValidator;

class DeleteByUuidForm extends ListForm
{
    public function __construct()
    {
        parent::__construct();

        $this
            ->addConditionForm(
                (new InConditionForm(
                    (new ArrayValidator())
                        ->addFilter(new TrimFilter())
                        ->addValidator(new UuidValidator())
                ))
                    ->setFilterableFields(['id'])
            );
    }
}
