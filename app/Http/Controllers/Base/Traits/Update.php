<?php

namespace App\Http\Controllers\Base\Traits;

use App\Criterias\Common\Query;
use App\Http\Requests\Base\BaseRequest;
use App\Services\Base\Contracts\CreateInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

trait Update
{
    protected string $resourceName;

    abstract protected function getService(): CreateInterface;

    abstract protected function getRequest(): BaseRequest;

    abstract protected function getResource(Model $data): JsonResource;

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id)
    {
        $data = $this->getRequest()->validated();
        $this->getService()->update(Query::eq('id', $id), $data);

        return response()->json([
            'message' => __('response.update', ['resource' => $this->resourceName]),
        ], Response::HTTP_OK);
    }
}
