<?php

namespace Nrg\Form;

use LogicException;
use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\Form\Helper\FiltersTrait;
use Nrg\Form\Helper\NameTrait;
use Nrg\Form\Helper\ParentTrait;
use Nrg\Form\Helper\ValidatorsTrait;
use Nrg\Form\Helper\ValueTrait;
use Nrg\I18n\Value\Message;

// todo: design cache for isValid()
class Form implements ElementInterface
{
    // todo: create parent class for Element and Form from traits below:
    use ErrorsTrait;
    use ParentTrait;
    use ValueTrait;
    use NameTrait;
    use FiltersTrait;
    use ValidatorsTrait;

    /** @var Element[] */
    public array $elements = [];

    public function addElement(ElementInterface $element): Form
    {
        $name = $element->hasName() ? $element->getName() : (string) count($this->elements);
        $this->elements[$name] = $element;
        $element->setParent($this);

        return $this;
    }

    public function hasElement(string $name): bool
    {
        return isset($this->elements[$name]);
    }

    public function getElement(string $name): ElementInterface
    {
        return $this->elements[$name];
    }

    public function setValue($data): ElementInterface
    {
        if (!is_array($data)) {
            if (null !== $data) {
                throw new LogicException('Only array or null are supported');
            }

            return $this;
        }

        $this->reset();

        foreach ($data as $name => $value) {
            if ($this->hasElement($name)) {
                $this->getElement($name)->setValue($data[$name]);
            }
        }

        $this->hasValue = true;

        return $this;
    }

    public function reset(): ElementInterface
    {
        foreach ($this->elements as $element) {
            $element->reset();
        }

        $this->errors = null;
        $this->hasValue = false;

        return $this;
    }

    public function isValid(): bool
    {
        $errors = null;

        if (!$this->hasValue() || $this->hasEmptyValue()) {
            if ($this->isRequired) {
                $this->setErrors(new Message('form_validation_isRequired')); // todo: Make as const in parent class
            }

            return !$this->hasErrors();
        }

        $this->applyFilters();

        foreach ($this->getValidators() as $validator) {
            if (!$validator->isValid($this)) {
                $errors = $validator->getErrors();

                break;
            }
        }

        $this->setErrors($errors);

        if ($this->hasErrors()) {
            return false;
        }

        return $this->isValidElements();
    }

    public function getValue(): array
    {
        $values = [];

        foreach ($this->elements as $name => $element) {
            if ($element->hasValue()) {
                $values[$name] = $element->getValue();
            }
        }

        return $values;
    }

    private function isValidElements(): bool
    {
        $errors = [];

        foreach ($this->elements as $name => $element) {
            if (!$element->isValid()) {
                $errors[$name] = $element->getErrors();
            }
        }

        $this->setErrors($errors);

        return !$this->hasErrors();
    }
}
