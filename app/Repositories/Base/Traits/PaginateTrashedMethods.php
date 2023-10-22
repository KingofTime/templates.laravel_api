<?php

namespace App\Repositories\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

trait PaginateTrashedMethods
{
    abstract protected function getModel(): Model;

    /**
     * @return LengthAwarePaginator<Model>
     */
    public function paginateInTrash(CriteriaInterface $criteria, int $page, int $per_page, string $page_name, string $order_by = null, string $sort = null): LengthAwarePaginator
    {
        $builder = $criteria->apply($this->getModel()) //@phpstan-ignore-line
            ->onlyTrashed();

        if ($order_by && $sort) {
            $builder->orderBy($order_by, $sort);
        }

        return $builder->paginate($per_page, ['*'], $page_name, $page);
    }
}
