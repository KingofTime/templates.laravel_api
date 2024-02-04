<?php

namespace App\Repositories\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface PaginateInterface extends RepositoryInterface
{
    /**
     * @return LengthAwarePaginator<Model>
     */
    public function paginate(CriteriaInterface $criteria, int $page, int $per_page, string $page_name, string $order_by = null, string $sort = null): LengthAwarePaginator;
}
