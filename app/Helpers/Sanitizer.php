<?php

namespace App\Helpers;

class Sanitizer
{
    private mixed $data;

    private array $sanitizer = [

    ];

    public function __construct(mixed $data, array $rules)
    {
        $this->data = $data;
    }

    public function run(): mixed
    {
        return $this->value;
    }
}
