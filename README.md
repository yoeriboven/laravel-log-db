
[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1" />](https://supportukrainenow.org)

# Laravel Database Logger

[![Latest Version on Packagist](https://img.shields.io/packagist/v/yoeriboven/laravel-log-db.svg?style=flat-square)](https://packagist.org/packages/yoeriboven/laravel-log-db)
[![GitHub Tests Action Status](https://github.com/yoeriboven/laravel-log-db/actions/workflows/run-tests.yml/badge.svg)](https://github.com/yoeriboven/laravel-log-db/actions/workflows/run-tests.yml)
[![GitHub Code Style Action Status](https://github.com/yoeriboven/laravel-log-db/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/yoeriboven/laravel-log-db/actions/workflows/php-cs-fixer.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/yoeriboven/laravel-log-db.svg?style=flat-square)](https://packagist.org/packages/yoeriboven/laravel-log-db)

This package provides a driver to store log messages in the database.

Tested on Laravel 9 and 10.

```php
use Illuminate\Support\Facades\Log;

Log::channel('db')->info('Your message');
```

## Installation

You can install the package via composer:

```bash
composer require yoeriboven/laravel-log-db
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="log-db-migrations"
php artisan migrate
```

Now add a new channel to `config/logging.php`.

```php
use Yoeriboven\LaravelLogDb\DatabaseLogger;

return [
    'channels' => [
        'db' => [
            'driver' => 'custom',
            'via'    => DatabaseLogger::class,
        ],
    ]   
]
```

## Usage

You could add the `db` channel to the `stack` channel and then log the normal way.

You could also explicitly log to the database:

```php
use Illuminate\Support\Facades\Log;

Log::channel('db')->info('Your message');
```

### Fallback channel

In case your database isn't ready you can assign a fallback driver to let you know of any issues.

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

If no fallback channel is defined it will default to the `single` channel.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Credits

- [Yoeri Boven](https://twitter.com/yoeriboven)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
