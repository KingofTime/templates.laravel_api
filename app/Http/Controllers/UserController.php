<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\Controller;
use App\Http\Controllers\Base\Traits\Destroy;
use App\Http\Controllers\Base\Traits\Index;
use App\Http\Controllers\Base\Traits\Show;
use App\Http\Controllers\Base\Traits\Store;
use App\Http\Controllers\Base\Traits\Update;
use App\Http\Requests\UserRequest;
use App\Http\Resources\Users\PaginatedUserCollection;
use App\Http\Resources\Users\UserCollection;
use App\Http\Resources\Users\UserResource;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    use Destroy, Index, Show, Store, Update;

    protected function getService(): UserService
    {
        return new UserService();
    }

    protected function getCollection(Collection $data): UserCollection
    {
        return new UserCollection($data);
    }

    protected function getPaginatedCollection(LengthAwarePaginator $data): PaginatedUserCollection
    {
        return new PaginatedUserCollection($data);
    }

    protected function getRequest(): UserRequest
    {
        return app(UserRequest::class);
    }

    protected function getResource(Model $data): UserResource
    {
        return new UserResource($data);
    }

    protected function getResourceName(): string
    {
        return 'users';
    }
}
