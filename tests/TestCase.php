<?php

namespace Yoeriboven\LaravelLogDb\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Yoeriboven\LaravelLogDb\DatabaseLoggerServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            DatabaseLoggerServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-log-db_table.php.stub';
        $migration->up();
        */
    }
}
