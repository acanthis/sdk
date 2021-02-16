<?php

namespace Nrg\Form\Helper;

trait ErrorsTrait
{
    private $errors;

    public function getErrors()
    {
        return $this->errors;
    }

    protected function setErrors($errors)
    {
        $this->errors = $errors;
    }

    protected function hasErrors(): bool
    {
        return !empty($this->errors);
    }
}
