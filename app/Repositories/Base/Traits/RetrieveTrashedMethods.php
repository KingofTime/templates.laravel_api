<?php

namespace App\Repositories\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait RetrieveTrashedMethods
{
    abstract protected function getModel(): Model;

    public function findInTrash(int $id): Model
    {
        return $this->getModel() //@phpstan-ignore-line
            ->onlyTrashed()
            ->findOrFail($id);
    }

    public function firstInTrash(CriteriaInterface $criteria): Model
    {
        $model = $criteria->apply($this->getModel())  //@phpstan-ignore-line
            ->onlyTrashed()
            ->first();

        if ($model == null) {
            throw new ModelNotFoundException();
        }

        return $model;
    }

    public function existsInTrash(CriteriaInterface $criteria): bool
    {
        return $criteria->apply($this->getModel()) //@phpstan-ignore-line
            ->onlyTrashed()
            ->exists();
    }
}
