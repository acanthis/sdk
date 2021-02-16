<?php

namespace Nrg\Data\Form;

use Nrg\Data\Dto\Filtering;
use Nrg\Data\Form\Element\ConditionFieldElement;
use Nrg\Data\Form\Element\ConditionNameElement;
use Nrg\Form\Form;

abstract class ConditionForm extends Form
{
    private ConditionFieldElement $conditionFieldElement;
    private array $filterableFields = [];

    public function __construct()
    {
        $this->conditionFieldElement = new ConditionFieldElement();
        $this
            ->addElement(new ConditionNameElement())
            ->addElement($this->conditionFieldElement)
        ;
    }

    public function setFilterableFields(array $fields): self
    {
        $this->filterableFields = $fields;
        $this->conditionFieldElement->setFilterableFields($fields);

        return $this;
    }

    public function canBeUsed(array $array): bool
    {
        return
            $this->getConditionName() === $array[Filtering::LITERAL_PROPERTY_NAME] &&
            $this->isFieldFilterable($array[Filtering::LITERAL_PROPERTY_FIELD]);
    }

    abstract protected function getConditionName(): string;

    private function isFieldFilterable(string $fieldName): bool
    {
        return empty($this->filterableFields) || in_array($fieldName, $this->filterableFields);
    }
}
