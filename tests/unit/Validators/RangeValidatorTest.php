<?php

use Codeception\Test\Unit;
use Nrg\Form\Element;
use Nrg\Form\Validator\RangeValidator;

class RangeValidatorTest extends Unit
{
    protected RangeValidator $rangeValidator;

    private Element $element;

    public function testLess()
    {
        $this->rangeValidator->setMinValue(5);
        $this->element->setValue(2);

        $this->assertFalse($this->rangeValidator->isValid($this->element));

        $this->element->setValue(5);
        $this->assertTrue($this->rangeValidator->isValid($this->element));

        $this->rangeValidator->setInclusive(false);
        $this->element->setValue(5);
        $this->assertFalse($this->rangeValidator->isValid($this->element));
    }

    public function testGreater()
    {
        $this->rangeValidator->setMaxValue(5);
        $this->element->setValue(3);

        $this->assertTrue($this->rangeValidator->isValid($this->element));

        $this->element->setValue(5);
        $this->assertTrue($this->rangeValidator->isValid($this->element));

        $this->rangeValidator->setInclusive(false);
        $this->element->setValue(5);
        $this->assertFalse($this->rangeValidator->isValid($this->element));
    }

    public function testRange()
    {
        $this->rangeValidator->setMinValue(2);
        $this->rangeValidator->setMaxValue(5);

        $this->element->setValue(2);
        $this->assertTrue($this->rangeValidator->isValid($this->element));

        $this->element->setValue(5);
        $this->assertTrue($this->rangeValidator->isValid($this->element));

        $this->element->setValue(1);
        $this->assertFalse($this->rangeValidator->isValid($this->element));

        $this->rangeValidator->setInclusive(false);
        $this->element->setValue(2);
        $this->assertFalse($this->rangeValidator->isValid($this->element));

        $this->element->setValue(5);
        $this->assertFalse($this->rangeValidator->isValid($this->element));

        $this->element->setValue(3);
        $this->assertTrue($this->rangeValidator->isValid($this->element));
    }

    public function testMinValueGreaterMaxValue()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('maxValue cannot be less than minValue');
        $this->rangeValidator->setMinValue(10);
        $this->rangeValidator->setMaxValue(5);
        $this->rangeValidator->isValid($this->element);
    }

    public function testMismatchType()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('minValue and maxValue cannot be different type');
        $this->rangeValidator->setMinValue(10);
        $this->rangeValidator->setMaxValue('ergwerger');
        $this->rangeValidator->isValid($this->element);
    }

    public function testMinValueNotScalar()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('minValue must be scalar type');
        $this->rangeValidator->setMinValue([]);
        $this->rangeValidator->setMinValue(new Class{});
    }

    public function testMaxValueNotScalar()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('maxValue must be scalar type');
        $this->rangeValidator->setMaxValue([]);
        $this->rangeValidator->setMaxValue(new Class{});
    }

    protected function _before()
    {
        $this->rangeValidator = new RangeValidator();
        $this->element = new Element('age');
    }
}
