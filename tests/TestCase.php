<?php

namespace Yoeriboven\LaravelLogDb\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Yoeriboven\LaravelLogDb\DatabaseLoggerServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
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
        config()->set('database.connections.custom', [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
    }

    protected function setUpDatabase()
    {
        $migration = include __DIR__.'/../database/migrations/create_laravel_log_table.php.stub';

        // Migrate default connection
        config()->set('logging.channels.db.connection', null);
        $migration->up();

        // Migrate custom connection
        config()->set('logging.channels.db.connection', 'custom');
        $migration->up();

        // Reset to default connection
        config()->set('logging.channels.db.connection', null);
    }
}
