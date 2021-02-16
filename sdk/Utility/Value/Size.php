<?php

namespace Nrg\Utility\Value;

/**
 * Size value implementation.
 */
class Size
{
    private const MULTIPLIERS = [
        'B' => 1,
        'KB' => 1024,
        'MB' => 1024 ** 2,
        'GB' => 1024 ** 3,
        'TB' => 1024 ** 4,
        'PB' => 1024 ** 5,
        'EB' => 1024 ** 6,
        'ZB' => 1024 ** 7,
        'YB' => 1024 ** 8,
    ];

    private const UNITS = ['KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

    private float $value;

    public function __construct(float $value)
    {
        $this->setValue($value);
    }

    public function __toString(): string
    {
        return (string) $this->getValue();
    }

    public static function fromHumanString(string $value): Size
    {
        $size = (float) $value;
        $multiplier = 1;

        if (strlen($size) !== strlen($value)) {
            $unit = strtoupper(trim(substr($value, strlen($size))));
            $multiplier = self::MULTIPLIERS[$unit];
        }

        return new self($size * $multiplier);
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value)
    {
        $this->value = $value;
    }

    public function toHumanString(): string
    {
        $bytes = $this->getValue();
        $thresh = 1024;

        if (abs($bytes) < $thresh) {
            return $bytes.' B';
        }

        $u = -1;
        do {
            $bytes /= $thresh;
            ++$u;
        } while (abs($bytes) >= $thresh && $u < count(self::UNITS) - 1);

        return round($bytes, 1).self::UNITS[$u];
    }
}
