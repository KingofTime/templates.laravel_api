<?php

namespace App\Repositories\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Model;

trait UpdateMethods
{
    abstract protected function getModel(): Model;

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(CriteriaInterface $criteria, array $data): void
    {
        $criteria->apply($this->getModel())
            ->firstOrFail()
            ->update($data);
    }
}
