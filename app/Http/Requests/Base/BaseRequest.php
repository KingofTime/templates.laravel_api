<?php

namespace App\Http\Requests\Base;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Validation\Validator;

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

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $response = response()->json($errors->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);
        throw new HttpResponseException($response);
    }
}
