<?php

namespace App\Criterias\Common;

use App\Criterias\Base\Criteria;
use App\Criterias\Contracts\CriteriaInterface;

class Query
{
    public static function all(): Criteria
    {
        return new Criteria();
    }

    public static function eq(string $field, mixed $value): EqualsCriteria
    {
        return new EqualsCriteria($field, $value);
    }

    public static function lt(string $field, mixed $value): LessThanCriteria
    {
        return new LessThanCriteria($field, $value);
    }

    public static function lte(string $field, mixed $value): LessThanEqualCriteria
    {
        return new LessThanEqualCriteria($field, $value);
    }

    public static function gt(string $field, mixed $value): GreaterThanCriteria
    {
        return new GreaterThanCriteria($field, $value);
    }

    public static function gte(string $field, mixed $value): GreaterThanEqualCriteria
    {
        return new GreaterThanEqualCriteria($field, $value);
    }

    public static function ne(string $field, string $value): NotEqualCriteria
    {
        return new NotEqualCriteria($field, $value);
    }

    /**
     * @param string $field
     * @param array<mixed> $values
     * @return InCriteria
     */
    public static function in(string $field, array $values): InCriteria
    {
        return new InCriteria($field, $values);
    }

    public static function like(string $field, string $term): LikeCriteria
    {
        return new LikeCriteria($field, $term);
    }

    public static function queue(CriteriaInterface ...$criterias): QueueCriteria
    {
        return new QueueCriteria($criterias);
    }
}
