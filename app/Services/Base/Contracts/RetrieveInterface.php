<?php

namespace App\Services\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Model;

interface RetrieveInterface extends ServiceInterface
{
    public function find(int $id): Model;

    public function first(CriteriaInterface $criteria): Model;
}
