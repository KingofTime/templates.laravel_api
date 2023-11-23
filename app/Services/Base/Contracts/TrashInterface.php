<?php

namespace App\Services\Base\Contracts;

interface TrashInterface extends ForceRemoveInterface, ListTrashedInterface, PaginateTrashedInterface, RestoreInterface, RetrieveTrashedInterface
{
}
