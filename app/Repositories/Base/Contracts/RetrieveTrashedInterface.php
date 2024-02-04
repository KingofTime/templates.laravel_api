<?php

namespace App\Repositories\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Model;

interface RetrieveTrashedInterface extends RepositoryInterface
{
    public function findInTrash(int $id): Model;

    public function firstInTrash(CriteriaInterface $criteria): Model;

    public function existsInTrash(CriteriaInterface $criteria): bool;
}
