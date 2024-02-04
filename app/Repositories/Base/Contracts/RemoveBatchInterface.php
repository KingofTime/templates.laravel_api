<?php

namespace App\Repositories\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface RemoveBatchInterface extends RepositoryInterface
{
    public function removeBatch(CriteriaInterface $criteria): void;
}
