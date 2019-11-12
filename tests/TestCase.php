<?php

namespace Tests;

use Orchestra\Testbench\BrowserKit\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $baseUrl = 'http://localhost';

    protected function setUp(): void {
        parent::setUp();
    }
}
