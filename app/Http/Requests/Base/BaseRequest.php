<?php

namespace App\Http\Requests\Base;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    public function all($keys = null)
    {
        $data = parent::all();
        $data = $this->sanitize($data);

        return $data;
    }

    protected function sanitize(array $data): array
    {
        return array_map(
            fn ($value) => htmlspecialchars(trim($value)),
            $data
        );
    }
}
