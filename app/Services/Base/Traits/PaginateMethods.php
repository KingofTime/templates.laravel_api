<?php

namespace App\Services\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use App\Repositories\Base\Contracts\PaginateInterface;
use Illuminate\Pagination\LengthAwarePaginator;

trait PaginateMethods
{
    abstract protected function getRepository(): PaginateInterface;

    /**
     * @return LengthAwarePaginator<Model>
     */
    public function paginate(CriteriaInterface $criteria, int $page, int $per_page, string $page_name, string $order = null, string $sort = null): LengthAwarePaginator
    {
        return $this->getRepository()->paginate($criteria, $page, $per_page, $page_name, $sort, $order);
    }
}
