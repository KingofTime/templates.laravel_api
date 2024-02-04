<?php

namespace App\Repositories\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface ForceRemoveInterface extends RepositoryInterface
{
    public function forceRemove(CriteriaInterface $criteria): void;
}
