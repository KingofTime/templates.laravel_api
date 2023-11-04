<?php

namespace App\Repositories\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait ForceRemoveBatchMethods
{
    public function forceRemoveBatch(CriteriaInterface $criteria): void
    {
        $builder = $criteria->apply($this->getModel()) //@phpstan-ignore-line
            ->onlyTrashed();

        if (count($builder->get()) == 0) {
            throw new ModelNotFoundException();
        }

        $builder->forceDelete();
    }
}
