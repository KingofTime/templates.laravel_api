<?php

namespace App\Services\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface RestoreBatchInterface
{
    public function restoreBatch(CriteriaInterface $criteria): void;
}
