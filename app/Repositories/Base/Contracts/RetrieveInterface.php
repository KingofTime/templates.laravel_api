<?php

namespace App\Repositories\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Model;

interface RetrieveInterface extends RepositoryInterface
{
    public function find(int $id): Model;

    public function first(CriteriaInterface $criteria): Model;

    public function exists(CriteriaInterface $criteria): bool;
}
