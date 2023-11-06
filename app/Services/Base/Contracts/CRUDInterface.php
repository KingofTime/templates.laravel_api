<?php

namespace App\Services\Base\Contracts;

interface CRUDInterface extends CreateInterface, ListInterface, PaginateInterface, RemoveInterface, RetrieveInterface, UpdateInterface
{
}
