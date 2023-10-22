<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function create()
    {
        new Sanitizer($data, [
            'name' => 'htmlescape|lower|logaritm',
        ]);
    }
}
