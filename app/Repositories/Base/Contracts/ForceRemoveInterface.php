<?php

namespace App\Repositories\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface ForceRemoveInterface
{
    public function forceRemove(CriteriaInterface $criteria): void;
}
