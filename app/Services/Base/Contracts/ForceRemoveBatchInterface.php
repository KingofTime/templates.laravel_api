<?php

namespace App\Services\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface ForceRemoveBatchInterface extends ServiceInterface
{
    public function forceRemoveBatch(CriteriaInterface $criteria): void;
}
