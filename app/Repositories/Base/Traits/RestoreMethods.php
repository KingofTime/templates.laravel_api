<?php

namespace App\Repositories\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Model;

trait RestoreMethods
{
    abstract protected function getModel(): Model;

    public function restore(CriteriaInterface $criteria): void
    {
        $criteria->apply($this->getModel()) //@phpstan-ignore-line
            ->onlyTrashed()
            ->firstOrFail()
            ->restore();
    }
}
