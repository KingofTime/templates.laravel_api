<?php

namespace App\Repositories\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait DeleteBatchMethods
{
    abstract protected function getModel(): Model;

    public function deleteBatch(CriteriaInterface $criteria): void
    {
        $builder = $criteria->apply($this->getModel());

        if (count($builder->get()) == 0) {
            throw new ModelNotFoundException();
        }

        $builder->delete();
    }
}
