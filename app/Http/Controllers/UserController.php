<?php

namespace App\Http\Controllers;

use App\Helpers\Parameters;
use App\Http\Resources\Users\PaginatedUserCollection;
use App\Http\Resources\Users\UserCollection;
use App\Http\Resources\Users\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $parameters = new Parameters($request);

        if ($parameters->hasPagination()) {
            $users = $this->userService->paginate(
                $parameters->getFilters(),
                $parameters->getPage(),
                $parameters->getPerPage(),
                'users.index',
                $parameters->getOrderBy(),
                $parameters->getSort()
            );

            $collection = new PaginatedUserCollection($users);
        } else {
            $users = $this->userService->list(
                $parameters->getFilters(),
                $parameters->getOrderBy(),
                $parameters->getSort()
            );

            $collection = new UserCollection($users);
        }

        return response()->json($collection, Response::HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->userService->find($id);
        $resource = new UserResource($user);

        return response()->json($resource, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
