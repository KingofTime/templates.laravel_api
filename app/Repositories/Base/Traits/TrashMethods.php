<?php

namespace App\Repositories\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

trait TrashMethods
{
    abstract protected function getModel(): Model;

    public function findInTrash(int $id): Model
    {
        return $this->getModel()
            ->onlyTrashed()::findOrFail($id);
    }

    public function firstInTrash(CriteriaInterface $criteria): ?Model
    {
        return $criteria->apply($this->getModel())
            ->onlyTrashed()
            ->first();
    }

    /**
     * @return Collection<int, Model>
     */
    public function getInTrash(CriteriaInterface $criteria, string $order_by, string $sort): Collection
    {
        return $criteria->apply($this->getModel())
            ->onlyTrashed()
            ->orderBy($order_by, $sort)
            ->get();
    }

    /**
     * @return LengthAwarePaginator<Collection<int, Model>>
     */
    public function paginateInTrash(CriteriaInterface $criteria, int $page, int $per_page, string $page_name, string $order_by, string $sort): LengthAwarePaginator
    {
        return $criteria->apply($this->getModel())
            ->onlyTrashed()
            ->orderBy($order_by, $sort)
            ->paginate($per_page, ['*'], $page_name, $page);
    }

    public function restore(CriteriaInterface $criteria): void
    {
        $criteria->apply($this->getModel())
            ->onlyTrashed()
            ->firstOrFail()
            ->restore();
    }

    public function forceDelete(CriteriaInterface $criteria): void
    {
        $criteria->apply($this->getModel())
            ->onlyTrashed()
            ->firstOrFail()
            ->forceDelete();
    }
}
