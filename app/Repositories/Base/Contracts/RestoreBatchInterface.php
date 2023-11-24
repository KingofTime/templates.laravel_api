<?php

namespace App\Repositories\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface RestoreBatchInterface extends RepositoryInterface
{
    public function restoreBatch(CriteriaInterface $criteria): void;
}
