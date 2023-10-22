<?php

namespace App\Repositories\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait RetrieveMethods
{
    abstract protected function getModel(): Model;

    public function find(int $id): Model
    {
        return $this->getModel()::findOrFail($id);
    }

    public function first(CriteriaInterface $criteria): Model
    {
        $model = $criteria->apply($this->getModel())->first();

        if ($model == null) {
            throw new ModelNotFoundException();
        }

        return $model;
    }

    public function exists(CriteriaInterface $criteria): bool
    {
        return $criteria->apply($this->getModel())
            ->exists();
    }
}
