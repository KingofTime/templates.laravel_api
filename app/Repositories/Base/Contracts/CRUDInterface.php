<?php

namespace App\Repositories\Base\Contracts;

interface CRUDInterface extends CreateInterface, ListInterface, PaginateInterface, RemoveInterface, RetrieveInterface, UpdateInterface
{
}
