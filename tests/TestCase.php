<?php

namespace Yoeriboven\LaravelLogDb\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Yoeriboven\LaravelLogDb\DatabaseLoggerServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

//        $this->setUpDatabase();
        $migration = include __DIR__.'/../database/migrations/create_laravel_log_table.php.stub';
        $migration->up();
    }

    protected function getPackageProviders($app)
    {
        return [
            DatabaseLoggerServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');


    }

//    protected function setUpDatabase()
//    {
//        (new CreateActivityLogTable())->up();
//        (new AddEventColumnToActivityLogTable())->up();
//        (new AddBatchUuidColumnToActivityLogTable())->up();
//    }
}
