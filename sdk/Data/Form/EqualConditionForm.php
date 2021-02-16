<?php

namespace Nrg\Data\Form;

use Nrg\Data\Dto\Filtering;
use Nrg\Data\Form\Element\ConditionValueElement;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Element;
use Nrg\Form\Validator\ScalarValidator;

class EqualConditionForm extends ConditionForm
{
    private Element $valueElement;

    public function __construct()
    {
        parent::__construct();

        $this->valueElement = new ConditionValueElement();

        $this->addElement(
            $this->valueElement
                ->addValidator(new ScalarValidator())
        );
    }

    public function addValueValidator(ValidatorInterface $validator): EqualConditionForm
    {
        $this->valueElement->addValidator($validator);

        return $this;
    }

    protected function getConditionName(): string
    {
        return Filtering::CONDITION_NAME_EQUAL;
    }
}
