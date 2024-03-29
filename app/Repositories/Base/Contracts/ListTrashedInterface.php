<?php

namespace App\Repositories\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ListTrashedInterface extends RepositoryInterface
{
    /**
     * @return Collection<int, Model>
     */
    public function listInTrash(CriteriaInterface $criteria, string $order_by = null, string $sort = null): Collection;
}
