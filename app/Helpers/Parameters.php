<?php

namespace App\Helpers;


use App\Criterias\Common\Query;
use App\Criterias\Common\QueueCriteria;
use Illuminate\Http\Request;

class Parameters
{
    const DEFAULT_PER_PAGE=10;
    private QueueCriteria $filters;

    public function __construct(Request $request)
    {
        $parameters = $request->toArray();

        $this->pagination = $this->extractPagination($parameters);
        $this->sorting = $this->extractSorting($parameters);
        $this->filters = $this->extractFilters($parameters);
    }

    private function extractPagination(array &$parameters): array
    {
        if(array_key_exists("page", $parameters)) {
            $pagination = array_intersect_key($parameters, ["per_page" => "", "page" => ""]);
        } else {
            $pagination = [];
        }

        unset($parameters["per_page"], $parameters["page"]);

        return $pagination;
    }

    private function extractSorting(array &$parameters): array
    {
        if(array_key_exists("order_by", $parameters)) {
            $sorting = array_intersect_key($parameters, ["order_by" => "", "sort" => ""]);
        } else {
            $sorting = [];
        }

        unset($parameters["order_by"], $parameters["sort"]);

        return $sorting;
    }

    private function extractFilters(array $parameters): QueueCriteria
    {
        $filters = Query::queue(...array_map(
            function($key, $value) {
                return Query::eq($key, $value);
            },
            array_keys($parameters),
            array_values($parameters)
        ));


        return $filters;
    }

    public function hasPagination()
    {
        return (bool) $this->pagination;
    }

    public function getFilters(): QueueCriteria
    {
        return $this->filters;
    }

    public function getPage()
    {
        return $this->pagination["page"];
    }

    public function getPerPage()
    {
        return $this->pagination["per_page"] ?? self::DEFAULT_PER_PAGE;
    }

    public function getOrderBy()
    {
        return $this->pagination["order_by"] ?? null;
    }

    public function getSort()
    {
        return $this->pagination["sort"] ?? null;
    }
}
