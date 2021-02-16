<?php

namespace Nrg\Form\Helper;

use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;

trait ValidatorsTrait
{
    /** @var ValidatorInterface[] */
    private array $validators = [];

    private bool $isRequired = false;

    public function addValidator(ValidatorInterface $validator)
    {
        $this->validators[] = $validator;

        return $this;
    }

    public function isRequired(): ElementInterface
    {
        $this->isRequired = true;

        return $this;
    }

    /** @return  ValidatorInterface[] */
    protected function getValidators(): array
    {
        return $this->validators;
    }
}
