<?php

namespace App\Repositories\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface ForceRemoveBatchInterface extends RepositoryInterface
{
    public function forceRemoveBatch(CriteriaInterface $criteria): void;
}
