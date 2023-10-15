<?php

namespace App\Repositories\Base;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class ResourceRepository extends Repository
{
    public function find(int $id): Model
    {
        return $this->getModel()::findOrFail($id);
    }

    public function first(CriteriaInterface $criteria): ?Model
    {
        return $criteria->apply($this->getModel())->first();
    }

    /**
     * @return Collection<int, Model>
     */
    public function get(CriteriaInterface $criteria, string $order_by = 'id', string $sort = 'asc'): Collection
    {
        return $criteria->apply($this->getModel())
            ->orderBy($order_by, $sort)
            ->get();
    }

    /**
     * @return LengthAwarePaginator<Model>
     */
    public function paginate(CriteriaInterface $criteria, int $page, int $per_page, string $page_name, string $order_by = 'id', string $sort = 'asc'): LengthAwarePaginator
    {
        return $criteria->apply($this->getModel())
            ->orderBy($order_by, $sort)
            ->paginate($per_page, ['*'], $page_name, $page);
    }

    public function exists(CriteriaInterface $criteria): bool
    {
        return $criteria->apply($this->getModel())
            ->exists();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Model
    {
        return $this->getModel()::create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(CriteriaInterface $criteria, array $data): void
    {
        $criteria->apply($this->getModel())
            ->firstOrFail()
            ->update($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function updateBatch(CriteriaInterface $criteria, array $data): void
    {
        $builder = $criteria->apply($this->getModel());

        if (count($builder->get()) == 0) {
            throw new ModelNotFoundException();
        }

        $builder->update($data);

    }

    public function delete(CriteriaInterface $criteria): void
    {
        $criteria->apply($this->getModel())
            ->firstOrFail()
            ->delete();
    }

    public function deleteBatch(CriteriaInterface $criteria): void
    {
        $builder = $criteria->apply($this->getModel());

        if (count($builder->get()) == 0) {
            throw new ModelNotFoundException();
        }

        $builder->delete();
    }
}
