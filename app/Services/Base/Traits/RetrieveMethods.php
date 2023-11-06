<?php

namespace App\Services\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use App\Repositories\Base\Contracts\RetrieveInterface;
use Illuminate\Database\Eloquent\Model;

trait RetrieveMethods
{
    abstract protected function getRepository(): RetrieveInterface;

    public function find(int $id): Model
    {
        return $this->getRepository()->find($id);
    }

    public function first(CriteriaInterface $criteria): Model
    {
        return $this->getRepository()->first($criteria);
    }
}
