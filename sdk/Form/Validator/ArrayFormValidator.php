<?php

namespace Nrg\Form\Validator;

use Nrg\Data\Dto\Filtering;
use Nrg\Data\Form\FilterForm;
use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Form;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;

class ArrayFormValidator implements ValidatorInterface
{
    use ErrorsTrait;

    private const ERROR = 'form_validation_notFoundMatchedForm';

    /** @var Form[] */
    private array $forms = [];

    public function isValid(ElementInterface $element): bool
    {
        $errors = [];

        foreach ($element->getValue() as $index => $array) {
            if (!is_int($index)) {
                $errors[$index] = new Message(self::ERROR);

                continue;
            }

            if (isset($array[Filtering::LITERAL_PROPERTY_UNION])) {
                $filterForm = new FilterForm();
                foreach ($this->forms as $form) {
                    $filterForm->addConditionForm($form);
                }
                $filterForm->setValue($array);
                if (!$filterForm->isValid()) {
                    $errors[$index] = $filterForm->getErrors();
                } else {
                    $errors[$index] = null;
                }

                continue;
            }

            $matchedForms = $this->getMatchedForms($array);

            if (empty($matchedForms)) {
                $errors[$index] = new Message(self::ERROR);

                continue;
            }

            foreach ($matchedForms as $matchedForm) {
                $matchedForm->setValue($array);
                if (!$matchedForm->isValid()) {
                    $errors[$index] = $matchedForm->getErrors();

                    break;
                }
                $errors[$index] = null;
            }
        }

        $this->setErrors($errors);

        return !$this->hasErrors();
    }

    public function addForm(Form $form): ArrayFormValidator
    {
        $this->forms[] = $form;

        return $this;
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

    /** @return  Form[] $array */
    private function getMatchedForms(array $array): array
    {
        $matchedForms = [];

        foreach ($this->forms as $index => $form) {
            if (!method_exists($form, 'canBeUsed') || $form->canBeUsed($array)) {
                $matchedForms[] = $form;
            }
        }

        return $matchedForms;
    }
}
