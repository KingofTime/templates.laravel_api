<?php

namespace App\Repositories\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ListInterface extends RepositoryInterface
{
    /**
     * @return Collection<int, Model>
     */
    public function list(CriteriaInterface $criteria, string $order_by = null, string $sort = null): Collection;
}
