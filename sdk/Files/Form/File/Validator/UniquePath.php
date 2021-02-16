<?php

namespace Nrg\Files\Form\File\Validator;

use Nrg\Files\UseCase\File\IsUniquePath;
use Nrg\Form\Abstraction\AbstractValidator;
use Nrg\Form\Element;

class UniquePath extends AbstractValidator
{
    public const CASE_ALREADY_EXISTS = 0;

    /**
     * @var IsUniquePath
     */
    private $isUniquePath;

    /**
     * @param IsUniquePath $isUniquePath
     */
    public function __construct(IsUniquePath $isUniquePath)
    {
        $this->isUniquePath = $isUniquePath;
        $this->adjustErrorText('File or directory \'%s\' already exists', self::CASE_ALREADY_EXISTS);
    }

    /**
     * @param Element $element
     *
     * @return bool
     */
    public function isValid(Element $element): bool
    {
        $this->setErrorCase(self::CASE_ALREADY_EXISTS, $element->getValue());

        return $this->isUniquePath->execute(['path' => $element->getValue()]);
    }
}