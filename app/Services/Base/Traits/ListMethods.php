<?php

namespace App\Services\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use App\Repositories\Base\Contracts\ListInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait ListMethods
{
    abstract protected function getRepository(): ListInterface;

    /**
     * @return Collection<int, Model>
     */
    public function list(CriteriaInterface $criteria, string $order_by = null, string $sort = null): Collection
    {
        return $this->getRepository()->list($criteria, $order_by, $sort);
    }
}
