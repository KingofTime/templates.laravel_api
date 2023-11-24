<?php

namespace App\Http\Controllers\Base\Traits;

use App\Helpers\Parameters;
use App\Http\Requests\Base\BaseRequest;
use App\Http\Resources\Base\PaginatedCollection;
use App\Services\Base\Contracts\IndexInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response;

trait Index
{
    abstract protected function getResourceName(): string;

    abstract protected function getService(): IndexInterface;

    abstract protected function getRequest(): BaseRequest;

    abstract protected function getCollection(Collection $data): ResourceCollection;

    abstract protected function getPaginatedCollection(LengthAwarePaginator $data): PaginatedCollection;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parameters = new Parameters($this->getRequest());

        if ($parameters->hasPagination()) {
            $data = $this->getService()->paginate(
                $parameters->getFilters(),
                $parameters->getPage(),
                $parameters->getPerPage(),
                "{$this->getResourceName()}.index",
                $parameters->getOrderBy(),
                $parameters->getSort()
            );

            $collection = $this->getPaginatedCollection($data);
        } else {
            $data = $this->getService()->list(
                $parameters->getFilters(),
                $parameters->getOrderBy(),
                $parameters->getSort()
            );

            $collection = $this->getCollection($data);
        }

        return response()->json($collection, Response::HTTP_OK);
    }
}
