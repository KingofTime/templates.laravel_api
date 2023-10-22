<?php

namespace App\Repositories\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait UpdateBatchMethods
{
    abstract protected function getModel(): Model;

    /**
     * @param  array<string, mixed>  $data
     */
    public function updateBatch(CriteriaInterface $criteria, array $data): void
    {
        $builder = $criteria->apply($this->getModel());

        if (count($builder->get()) == 0) {
            throw new ModelNotFoundException();
        }

        $builder->update($data);

    }
}
