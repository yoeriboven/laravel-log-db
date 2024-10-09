
[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1" />](https://supportukrainenow.org)

# Laravel Database Logger

[![Latest Version on Packagist](https://img.shields.io/packagist/v/yoeriboven/laravel-log-db.svg?style=flat-square)](https://packagist.org/packages/yoeriboven/laravel-log-db)
[![GitHub Tests Action Status](https://github.com/yoeriboven/laravel-log-db/actions/workflows/run-tests.yml/badge.svg)](https://github.com/yoeriboven/laravel-log-db/actions/workflows/run-tests.yml)
[![GitHub Code Style Action Status](https://github.com/yoeriboven/laravel-log-db/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/yoeriboven/laravel-log-db/actions/workflows/php-cs-fixer.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/yoeriboven/laravel-log-db.svg?style=flat-square)](https://packagist.org/packages/yoeriboven/laravel-log-db)

This package provides a custom log driver for storing Laravel log messages in the database.

Compatible with Laravel 9, 10 and 11.

```php
use Illuminate\Support\Facades\Log;

Log::channel('db')->info('Your message');
```

## Installation

Install the package via Composer:

```bash
composer require yoeriboven/laravel-log-db
```

Publish and run the migrations:

```bash
php artisan vendor:publish --tag="log-db-migrations"
php artisan migrate
```

Next, configure the db log channel in `config/logging.php`:

```php
use Yoeriboven\LaravelLogDb\DatabaseLogger;

return [
    'channels' => [
        'db' => [
            'driver'     => 'custom',
            'via'        => DatabaseLogger::class,
            'connection' => env('LOG_DB_CONNECTION'), // Optional, defaults to app's DB connection
            'days'       => 7, // Optional, retention period in days
        ],
    ]   
]
```

## Usage

To use the db log channel, either:

1. Add it to the stack channel for combined logging:
```php
// config/logging.php
return [
    'channels' => [
        'stack' => [
            'channels' => ['single', 'db'],
        ],
        // other channels
    ]
]
```
2. Log directly to the database:

```
use Illuminate\Support\Facades\Log;

Log::channel('db')->info('Your log message');
```

### Fallback channel

If the database is unavailable, you can define a fallback channel to handle logs:

```php
// config/logging.php

return [
    'channels' => [
        'fallback' => [
            'channels' => ['single'],
        ],
    ]   
]
```

### Pruning the logs
To automatically delete logs older than a specified number of days, set the `days` key in the configuration and schedule log pruning:

```php
$schedule->command('model:prune', [
    '--model' => [
        \Yoeriboven\LaravelLogDb\Models\LogMessage::class,
    ],
])->daily();
```

If no fallback channel is defined it will default to the `single` channel.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Credits

- [Yoeri Boven](https://twitter.com/yoeriboven)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
