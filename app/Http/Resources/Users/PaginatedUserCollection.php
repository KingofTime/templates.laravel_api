<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Base\PaginatedCollection;
use Illuminate\Http\Request;

class PaginatedUserCollection extends PaginatedCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
