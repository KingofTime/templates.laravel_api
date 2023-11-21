<?php

namespace App\Services\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use App\Repositories\Base\Contracts\PaginateTrashedInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

trait PaginateTrashedMethods
{
    abstract protected function getRepository(): PaginateTrashedInterface;

    /**
     * @return LengthAwarePaginator<Model>
     */
    public function paginateInTrash(CriteriaInterface $criteria, int $page, int $per_page, string $page_name, string $order = null, string $sort = null): LengthAwarePaginator
    {
        return $this->getRepository()->paginateInTrash($criteria, $page, $per_page, $page_name, $sort, $order);
    }
}
