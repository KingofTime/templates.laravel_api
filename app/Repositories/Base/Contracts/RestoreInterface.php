<?php

namespace App\Repositories\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface RestoreInterface extends RepositoryInterface
{
    public function restore(CriteriaInterface $criteria): void;
}
