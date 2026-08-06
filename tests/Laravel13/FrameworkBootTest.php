<?php

namespace Tests\Laravel13;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase;

class FrameworkBootTest extends TestCase
{
    public function createApplication()
    {
        $app = require __DIR__.'/../../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    public function test_health_endpoint_is_available(): void
    {
        $this->get('/up')->assertNoContent();
    }
}
