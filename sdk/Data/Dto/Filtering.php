<?php

namespace Nrg\Data\Dto;

use Nrg\Data\Abstraction\ConditionInterface;
use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Condition\GreaterCondition;
use Nrg\Data\Condition\GreaterOrEqualCondition;
use Nrg\Data\Condition\InCondition;
use Nrg\Data\Condition\LessCondition;
use Nrg\Data\Condition\LessOrEqualCondition;
use Nrg\Data\Condition\LikeCondition;
use Nrg\Data\Condition\NotEqualCondition;
use Nrg\Data\Condition\NotInCondition;
use Nrg\Data\Condition\NotLikeCondition;
use Nrg\Data\Condition\OutRangeCondition;
use Nrg\Data\Condition\RangeCondition;
use Nrg\Utility\PopulateProps;

class Filtering
{
    use PopulateProps;

    public const LITERAL_PROPERTY_UNION = 'union';
    public const LITERAL_PROPERTY_CONDITIONS = 'conditions';
    public const LITERAL_PROPERTY_NAME = 'name';
    public const LITERAL_PROPERTY_FIELD = 'field';

    public const CONDITION_NAME_EQUAL = 'equal';
    public const CONDITION_NAME_ENUM = 'enum';
    public const CONDITION_NAME_NOT_EQUAL = 'notEqual';
    public const CONDITION_NAME_RANGE = 'range';
    public const CONDITION_NAME_OUT_RANGE = 'outRange';
    public const CONDITION_NAME_GREATER = 'greater';
    public const CONDITION_NAME_GREATER_OR_EQUAL = 'greaterOrEqual';
    public const CONDITION_NAME_LESS = 'less';
    public const CONDITION_NAME_LESS_OR_EQUAL = 'lessOrEqual';
    public const CONDITION_NAME_IN = 'in';
    public const CONDITION_NAME_NOT_IN = 'notIn';
    public const CONDITION_NAME_LIKE = 'like';
    public const CONDITION_NAME_NOT_LIKE = 'notLike';

    public const CONDITION_CLASS_MAP = [
        self::CONDITION_NAME_EQUAL => EqualCondition::class,
        self::CONDITION_NAME_ENUM => EqualCondition::class,
        self::CONDITION_NAME_NOT_EQUAL => NotEqualCondition::class,
        self::CONDITION_NAME_RANGE => RangeCondition::class,
        self::CONDITION_NAME_OUT_RANGE => OutRangeCondition::class,
        self::CONDITION_NAME_GREATER => GreaterCondition::class,
        self::CONDITION_NAME_GREATER_OR_EQUAL => GreaterOrEqualCondition::class,
        self::CONDITION_NAME_LESS => LessCondition::class,
        self::CONDITION_NAME_LESS_OR_EQUAL => LessOrEqualCondition::class,
        self::CONDITION_NAME_IN => InCondition::class,
        self::CONDITION_NAME_NOT_IN => NotInCondition::class,
        self::CONDITION_NAME_LIKE => LikeCondition::class,
        self::CONDITION_NAME_NOT_LIKE => NotLikeCondition::class,
    ];

    private ?Filter $filter = null;

    public function __construct(array $data = [])
    {
        $this->populateProps($data);

        if (null === $this->filter) {
            $this->filter = new Filter();
        }
    }

    public function getFilter(): Filter
    {
        return $this->filter;
    }

    public static function isFilter(array $data): bool
    {
        return isset($data[self::LITERAL_PROPERTY_UNION], $data[self::LITERAL_PROPERTY_CONDITIONS]);
    }

    private function getCondition(array $condition): ConditionInterface
    {
        $class = self::CONDITION_CLASS_MAP[$condition[self::LITERAL_PROPERTY_NAME]];
        unset($condition[self::LITERAL_PROPERTY_NAME]);

        return new $class($condition);
    }

    private function setFilter(array $data): void
    {
        $this->filter = $this->buildFilter($data);
    }

    private function buildFilter(array $data): Filter
    {
        if (empty($data)) {
            return new Filter();
        }

        $filter = new Filter($data[self::LITERAL_PROPERTY_UNION]);

        foreach ($data[self::LITERAL_PROPERTY_CONDITIONS] as $item) {
            if (self::isFilter($item)) {
                $filter->addFilter($this->buildFilter($item));
            } else {
                $filter->addCondition($this->getCondition($item));
            }
        }

        return $filter;
    }
}
