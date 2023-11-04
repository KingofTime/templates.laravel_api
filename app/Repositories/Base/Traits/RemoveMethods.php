<?php

namespace App\Repositories\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Model;

trait RemoveMethods
{
    abstract protected function getModel(): Model;

    public function remove(CriteriaInterface $criteria): void
    {
        $criteria->apply($this->getModel())
            ->firstOrFail()
            ->delete();
    }
}
