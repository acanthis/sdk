<?php

namespace Nrg\Form\Abstraction;

use Nrg\Form\Validator\ArrayValidator;

interface ElementInterface
{
    public function isValid(): bool;

    public function getName(): string;

    public function setName(string $name): ElementInterface;

    public function hasName(): bool;

    public function setValue($value): ElementInterface;

    public function hasValue(): bool;

    public function hasEmptyValue(): bool;

    public function getValue();

    public function setParent(ElementInterface $parent);

    public function hasParent(): bool;

    public function getParent(): ElementInterface;

    public function getErrors();

    /**@return ElementInterface|ArrayValidator */
    public function addFilter(FilterInterface $filter);

    /**@return ElementInterface|ArrayValidator */
    public function addValidator(ValidatorInterface $validator);

    public function isRequired(): ElementInterface;
}
