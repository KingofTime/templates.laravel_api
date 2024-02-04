<?php

namespace App\Http\Controllers\Base\Traits;

use App\Http\Requests\Base\BaseRequest;
use App\Services\Base\Contracts\CreateInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

trait Store
{
    protected string $resourceName;

    abstract protected function getService(): CreateInterface;

    abstract protected function getRequest(): BaseRequest;

    abstract protected function getResource(Model $data): JsonResource;

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $data = $this->getRequest()->validated();
        $user = $this->getService()->create($data);
        $resource = $this->getResource($user);

        return response()->json([
            'message' => __('response.store', ['resource' => $this->resourceName]),
            'data' => $resource,
        ], Response::HTTP_CREATED);
    }
}
