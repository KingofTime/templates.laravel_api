<?php

namespace App\Repositories\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

trait TrashMethods
{
    abstract protected function getModel(): Model;

    public function findInTrash(int $id): Model
    {
        return $this->getModel() //@phpstan-ignore-line
            ->onlyTrashed()
            ->findOrFail($id);
    }

    public function firstInTrash(CriteriaInterface $criteria): ?Model
    {
        return $criteria->apply($this->getModel())  //@phpstan-ignore-line
            ->onlyTrashed()
            ->first();
    }

    /**
     * @return Collection<int, Model>
     */
    public function getInTrash(CriteriaInterface $criteria, string $order_by = 'id', string $sort = 'asc'): Collection
    {
        return $criteria->apply($this->getModel()) //@phpstan-ignore-line
            ->onlyTrashed()
            ->orderBy($order_by, $sort)
            ->get();
    }

    /**
     * @return LengthAwarePaginator<Collection<int, Model>>
     */
    public function paginateInTrash(CriteriaInterface $criteria, int $page, int $per_page, string $page_name, string $order_by = 'id', string $sort = 'asc'): LengthAwarePaginator
    {
        return $criteria->apply($this->getModel()) //@phpstan-ignore-line
            ->onlyTrashed()
            ->orderBy($order_by, $sort)
            ->paginate($per_page, ['*'], $page_name, $page);
    }

    public function restore(CriteriaInterface $criteria): void
    {
        $criteria->apply($this->getModel()) //@phpstan-ignore-line
            ->onlyTrashed()
            ->firstOrFail()
            ->restore();
    }

    public function restoreBatch(CriteriaInterface $criteria): void
    {
        $builder = $criteria->apply($this->getModel())
            ->onlyTrashed();

        if (count($builder->get()) == 0) {
            throw new ModelNotFoundException();
        }

        $builder->restore();
    }

    public function forceDelete(CriteriaInterface $criteria): void
    {
        $criteria->apply($this->getModel()) //@phpstan-ignore-line
            ->onlyTrashed()
            ->firstOrFail()
            ->forceDelete();
    }

    public function forceDeleteBatch(CriteriaInterface $criteria): void
    {
        $builder = $criteria->apply($this->getModel())
            ->onlyTrashed();

        if (count($builder->get()) == 0) {
            throw new ModelNotFoundException();
        }

        $builder->forceDelete();
    }
}
