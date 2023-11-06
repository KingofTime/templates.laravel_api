<?php

namespace App\Repositories\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface RestoreBatchInterface
{
    public function restoreBatch(CriteriaInterface $criteria): void;
}
