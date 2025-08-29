<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        require_once __DIR__ . '/../database/factories/BrandFactory.php';
        require_once __DIR__ . '/../database/factories/CategorieFactory.php';
        require_once __DIR__ . '/../database/factories/CarFactory.php';
        require_once __DIR__ . '/../database/factories/ClientFactory.php';
        require_once __DIR__ . '/../database/factories/AchatFactory.php';
    }
}
