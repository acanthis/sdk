<?php

namespace Nrg\Form;

use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\Form\Helper\FiltersTrait;
use Nrg\Form\Helper\NameTrait;
use Nrg\Form\Helper\ParentTrait;
use Nrg\Form\Helper\ValidatorsTrait;
use Nrg\Form\Helper\ValueTrait;
use Nrg\I18n\Value\Message;

class Element implements ElementInterface
{
    use FiltersTrait;
    use ValidatorsTrait;
    use ErrorsTrait;
    use ParentTrait;
    use ValueTrait;
    use NameTrait;

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

        return !$this->hasErrors();
    }
}
