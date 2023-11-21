<?php

namespace App\Services\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use App\Repositories\Base\Contracts\RetrieveTrashedInterface;
use Illuminate\Database\Eloquent\Model;

trait RetrieveTrashedMethods
{
    abstract protected function getRepository(): RetrieveTrashedInterface;

    public function findInTrash(int $id): Model
    {
        return $this->getRepository()->findInTrash($id);
    }

    public function firstInTrash(CriteriaInterface $criteria): Model
    {
        return $this->getRepository()->firstInTrash($criteria);
    }
}
