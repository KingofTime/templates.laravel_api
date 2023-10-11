<?php

namespace App\Criterias\Common;

use App\Criterias\Base\OperatorCriteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class InCriteria extends OperatorCriteria
{
    /**
     * @param string $field
     * @param array<mixed> $value
     */
    public function __construct(string $field, array $value)
    {
        parent::__construct($field, $value);
    }
    /**
     * @param Model|Builder<Model> $builder
     * @return Model|Builder<Model>
     */
    public function apply(Model|Builder $builder): Model|Builder
    {
        return $builder->whereIn(
            $this->field,
            $this->value
        );
    }
}
