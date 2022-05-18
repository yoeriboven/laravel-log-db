<?php

namespace Yoeriboven\LaravelLogDb;

use Monolog\Logger;

class DatabaseLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @return Logger
     */
    public function __invoke(array $config)
    {
        return new Logger('Database', [
            new DatabaseHandler(),
        ]);
    }
}
