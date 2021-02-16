<?php

namespace Nrg\Files\Form\File\Element;

use Nrg\Files\Form\File\Validator\PathValidator;
use Nrg\Form\Element;
use Nrg\Form\Validator\IsStringValidator;

class PathElement extends Element
{
    public function __construct(string $name = 'path')
    {
        parent::__construct($name);

        $this
            ->addValidator(new IsStringValidator())
            ->addValidator(new PathValidator());
    }
}