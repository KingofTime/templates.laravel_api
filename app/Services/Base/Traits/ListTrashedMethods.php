<?php

namespace App\Services\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use App\Repositories\Base\Contracts\ListTrashedInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait ListTrashedMethods
{
    abstract protected function getRepository(): ListTrashedInterface;

    /**
     * @return Collection<int, Model>
     */
    public function listInTrash(CriteriaInterface $criteria, string $order_by = null, string $sort = null): Collection
    {
        return $this->getRepository()->listInTrash($criteria, $order_by, $sort);
    }
}
