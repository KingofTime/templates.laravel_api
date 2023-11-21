<?php

namespace App\Services\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Model;

interface RetrieveTrashedInterface
{
    public function findInTrash(int $id): Model;

    public function firstInTrash(CriteriaInterface $criteria): Model;
}
