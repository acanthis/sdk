<?php

use Codeception\Test\Unit;
use Nrg\Form\Element;
use Nrg\Form\Validator\LengthStringRangeValidator;

class LengthRangeValidatorTest extends Unit
{
    protected LengthStringRangeValidator $lengthRangeValidator;

    private Element $element;

    public function testLengthLess()
    {
        $this->lengthRangeValidator->setMinLength(5);
        $this->element->setValue('name');

        $this->assertFalse($this->lengthRangeValidator->isValid($this->element));

        $this->element->setValue('name1');
        $this->assertTrue($this->lengthRangeValidator->isValid($this->element));

        $this->lengthRangeValidator->setInclusive(false);
        $this->element->setValue('name1');
        $this->assertFalse($this->lengthRangeValidator->isValid($this->element));
    }

    public function testLengthGreater()
    {
        $this->lengthRangeValidator->setMaxLength(5);
        $this->element->setValue('name');

        $this->assertTrue($this->lengthRangeValidator->isValid($this->element));

        $this->element->setValue('name13');
        $this->assertFalse($this->lengthRangeValidator->isValid($this->element));

        $this->lengthRangeValidator->setInclusive(false);
        $this->element->setValue('name1');
        $this->assertFalse($this->lengthRangeValidator->isValid($this->element));
    }

    public function testLengthRange()
    {
        $this->lengthRangeValidator->setMinLength(2);
        $this->lengthRangeValidator->setMaxLength(5);

        $this->element->setValue('name');
        $this->assertTrue($this->lengthRangeValidator->isValid($this->element));

        $this->element->setValue('na');
        $this->assertTrue($this->lengthRangeValidator->isValid($this->element));

        $this->element->setValue('name12');
        $this->assertFalse($this->lengthRangeValidator->isValid($this->element));

        $this->lengthRangeValidator->setInclusive(false);
        $this->element->setValue('na');
        $this->assertFalse($this->lengthRangeValidator->isValid($this->element));

        $this->element->setValue('name1');
        $this->assertFalse($this->lengthRangeValidator->isValid($this->element));
    }

    public function testMinLengthGreaterMaxLength()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('maxLength cannot be less than minLength');
        $this->lengthRangeValidator->setMinLength(10);
        $this->lengthRangeValidator->setMaxLength(5);
        $this->lengthRangeValidator->isValid($this->element);
    }

    public function testMinLengthEqualMaxLength()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('minLength and maxLength cannot be equal. Use LengthEqualValidator');
        $this->lengthRangeValidator->setMinLength(10);
        $this->lengthRangeValidator->setMaxLength(10);
        $this->lengthRangeValidator->isValid($this->element);
    }

    protected function _before()
    {
        $this->lengthRangeValidator = new LengthStringRangeValidator();
        $this->element = new Element('name');
    }
}
