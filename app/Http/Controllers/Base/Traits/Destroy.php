<?php

namespace App\Http\Controllers\Base\Traits;

use App\Criterias\Common\Query;
use App\Services\Base\Contracts\CreateInterface;
use Symfony\Component\HttpFoundation\Response;

trait Destroy
{
    protected string $resourceName;

    abstract protected function getService(): CreateInterface;

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->getService()->remove(Query::eq('id', $id));

        return response()->json([
            'message' => __('response.destroy', ['resource' => $this->resourceName]),
        ], Response::HTTP_OK);
    }
}
