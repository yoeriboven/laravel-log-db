<?php

namespace Yoeriboven\LaravelLogDb;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Yoeriboven\LaravelLogDb\Commands\LaravelLogDbCommand;

class LaravelLogDbServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-log-db')
            ->hasConfigFile()
            ->hasMigration('create_laravel-log-db_table');
    }
}
