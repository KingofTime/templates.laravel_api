<?php

namespace App\Repositories\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Model;

trait DeleteMethods
{
    abstract protected function getModel(): Model;

    public function delete(CriteriaInterface $criteria): void
    {
        $criteria->apply($this->getModel())
            ->firstOrFail()
            ->delete();
    }
}
