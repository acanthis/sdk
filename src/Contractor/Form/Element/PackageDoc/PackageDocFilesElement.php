<?php

namespace Eds\Contractor\Form\Element\PackageDoc;

use Nrg\Form\Element;
use Nrg\Form\Validator\ArrayValidator;
use Nrg\Form\Validator\FileValidator;

class PackageDocFilesElement extends Element
{
    public function __construct(array $allowTypes, int $maxFileSize)
    {
        $this
            ->setName('files')
            ->addValidator(
                (new ArrayValidator())
                    ->addValidator(
                        (new FileValidator($allowTypes, $maxFileSize))
                    )
            )
        ;
    }
}