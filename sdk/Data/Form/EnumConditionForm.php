<?php

namespace Nrg\Data\Form;

use Nrg\Data\Dto\Filtering;
use Nrg\Data\Form\Element\ConditionValueElement;
use Nrg\Form\Validator\InArrayValidator;

class EnumConditionForm extends ConditionForm
{
    private InArrayValidator $inArrayValidator;

    public function __construct()
    {
        parent::__construct();

        $this->inArrayValidator = new InArrayValidator();
        $this
            ->addElement(
                (new ConditionValueElement())
                    ->addValidator($this->inArrayValidator)
            )
        ;
    }

    public function setEnum(array $haystack): EnumConditionForm
    {
        $this->inArrayValidator->setHaystack($haystack);

        return $this;
    }

    protected function getConditionName(): string
    {
        return Filtering::CONDITION_NAME_ENUM;
    }
}
