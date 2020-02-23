<?php

namespace Reducktion\Socrates\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Reducktion\Socrates\Facades\Socrates;
use Reducktion\Socrates\SocratesServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            SocratesServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Socrates' => Socrates::class
        ];
    }
}