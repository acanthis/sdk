<?php

namespace Nrg\Form\Validator;

use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Element;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\Form\Helper\FiltersTrait;
use Nrg\Form\Helper\ValidatorsTrait;
use Nrg\I18n\Value\Message;

class ArrayValidator implements ValidatorInterface
{
    use ErrorsTrait;
    use FiltersTrait;
    use ValidatorsTrait;

    private const ERROR_NOT_ARRAY = 'form_validation_isNotArray';
    private const ERROR_ARRAY_EMPTY = 'form_validation_cannotBeEmpty';

    private bool $isNotEmpty = true;

    public function isValid(ElementInterface $element): bool
    {
        if (!is_array($element->getValue())) {
            $this->setErrors(new Message(self::ERROR_NOT_ARRAY));

            return false;
        }

        if ($this->isNotEmpty && empty($element->getValue())) {
            $this->setErrors(new Message(self::ERROR_ARRAY_EMPTY));

            return false;
        }

        if ($this->getFilters() || $this->getValidators()) {
            $elements = $this->createElements($element);
            $errors = [];

            foreach ($elements as $element) {
                $errors[(int)$element->getName()] = $element->isValid() ? null : $element->getErrors();
            }

            $this->setErrors($errors);
        }

        return !$this->hasErrors();
    }

    protected function hasErrors(): bool
    {
        foreach ($this->getErrors() as $error) {
            if (null !== $error) {
                return true;
            }
        }

        return false;
    }

    /** @return ElementInterface[] */
    private function createElements(ElementInterface $element): array
    {
        $elements = [];

        foreach ($element->getValue() as $key => $value) {
            $itemElement = (new Element())
                ->setName((string) $key)
            ;

            foreach ($this->getFilters() as $filter) {
                $itemElement->addFilter($filter);
            }

            foreach ($this->getValidators() as $validatorIndex => $validator) {
                $itemElement->addValidator($validator);
            }

            $itemElement->setValue($value);

            $elements[] = $itemElement;
        }

        return $elements;
    }

    public function setIsNotEmpty(bool $isNotEmpty): ArrayValidator
    {
        $this->isNotEmpty = $isNotEmpty;

        return $this;
    }
}
