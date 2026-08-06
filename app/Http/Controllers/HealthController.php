<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class HealthController
{
    public function __invoke(): Response
    {
        return response()->noContent();
    }
}
