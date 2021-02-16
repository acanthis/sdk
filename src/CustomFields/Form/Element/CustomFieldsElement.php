<?php

namespace Eds\CustomFields\Form\Element;

use Eds\CustomFields\Form\Type\BooleanTypeForm;
use Eds\CustomFields\Form\Type\ClientDataListTypeForm;
use Eds\CustomFields\Form\Type\DateTypeForm;
use Eds\CustomFields\Form\Type\FloatTypeForm;
use Eds\CustomFields\Form\Type\IntegerTypeForm;
use Eds\CustomFields\Form\Type\NumericTypeForm;
use Eds\CustomFields\Form\Type\SystemDataListTypeForm;
use Eds\CustomFields\Form\Type\TextTypeForm;
use Nrg\Form\Element;
use Nrg\Form\Validator\ArrayFormValidator;

class CustomFieldsElement extends Element
{
    public function __construct()
    {
        $this
            ->addValidator(
                (new ArrayFormValidator)
                    ->addForm(new BooleanTypeForm())
                    ->addForm(new DateTypeForm())
                    ->addForm(new FloatTypeForm())
                    ->addForm(new IntegerTypeForm())
                    ->addForm(new NumericTypeForm())
                    ->addForm(new TextTypeForm())
                    ->addForm(new SystemDataListTypeForm())
                    ->addForm(new ClientDataListTypeForm())
            )
        ;
    }
}
