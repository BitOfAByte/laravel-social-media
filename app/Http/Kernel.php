<?php

namespace App\Http;

use App\Http\Middleware\AuthCheck;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middlewareGroups = [
        'web' => [
            AuthCheck::class,
        ],
    ];
}
