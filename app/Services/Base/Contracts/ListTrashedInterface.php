<?php

namespace App\Services\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ListTrashedInterface extends ServiceInterface
{
    /**
     * @return Collection<int, Model>
     */
    public function listInTrash(CriteriaInterface $criteria, string $order_by = null, string $sort = null): Collection;
}
