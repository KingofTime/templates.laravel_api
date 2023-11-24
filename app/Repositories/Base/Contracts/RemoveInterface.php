<?php

namespace App\Repositories\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface RemoveInterface extends RepositoryInterface
{
    public function remove(CriteriaInterface $criteria): void;
}
