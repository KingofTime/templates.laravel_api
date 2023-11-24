<?php

namespace App\Http\Controllers\Base\Traits;

use App\Services\Base\Contracts\RetrieveInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

trait Show
{
    protected string $resourceName;

    abstract protected function getService(): RetrieveInterface;

    abstract protected function getResource(Model $data): JsonResource;

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->getService()->find($id);
        $resource = $this->getResource($data);

        return response()->json($resource, Response::HTTP_OK);
    }
}
