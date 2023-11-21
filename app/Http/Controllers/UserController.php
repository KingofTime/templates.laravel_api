<?php

namespace App\Http\Controllers;

use App\Criterias\Common\Query;
use App\Helpers\Parameters;
use App\Services\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $parameters = new Parameters($request);

        if ($parameters->hasPagination()) {
            $collection = $this->userService->paginate(
                $parameters->getFilters(),
                $parameters->getPage(),
                $parameters->getPerPage(),
                "users.index",
                $parameters->getOrderBy(),
                $parameters->getSort()
            );
        } else {
            $collection = $this->userService->list(
                $parameters->getFilters(),
                $parameters->getOrderBy(),
                $parameters->getSort()
            );
        }

        return response()->json($collection, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        //
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
