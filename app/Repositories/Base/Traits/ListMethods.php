<?php

namespace App\Repositories\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait ListMethods
{
    abstract protected function getModel(): Model;

    /**
     * @return Collection<int, Model>
     */
    public function list(CriteriaInterface $criteria, string $order_by = null, string $sort = null): Collection
    {
        $builder = $criteria->apply($this->getModel());

        if ($order_by && $sort) {
            $builder->orderBy($order_by, $sort);
        }

        return $builder->get();
    }
}
