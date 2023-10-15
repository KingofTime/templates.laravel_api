<?php

namespace App\Criterias\Common;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class QueueCriteria implements CriteriaInterface
{
    /**
     * @param  array<CriteriaInterface>  $criterias
     */
    public function __construct(
        protected array $criterias = []
    ) {
    }

    public function append(CriteriaInterface $criteria): void
    {
        $this->criterias[] = $criteria;
    }

    /**
     * @param  Model|Builder<Model>  $builder
     * @return Model|Builder<Model>
     */
    public function apply(Model|Builder $builder): Model|Builder
    {
        foreach ($this->criterias as $criteria) {
            $builder = $criteria->apply($builder);
        }

        return $builder;
    }
}
