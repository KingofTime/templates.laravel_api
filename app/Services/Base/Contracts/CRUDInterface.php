<?php

namespace App\Services\Base\Contracts;

interface CRUDInterface extends CreateInterface, IndexInterface, RemoveInterface, RetrieveInterface, UpdateInterface
{
}
