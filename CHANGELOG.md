# Changelog

### 2.1
- Added support for Laravel 12

### 2.0
- Added support for PHP 8.4
- Adds support for minimum log levels [#28](https://github.com/yoeriboven/laravel-log-db/pull/28)
- Breaking change: [Cast logged_at to immutable datetime object](https://github.com/yoeriboven/laravel-log-db/pull/33)

### 1.4
- Added support for pruning the logs

### 1.3
- Added support for custom database connections

### 1.2.2
- Fixes bug when array key formatted is not set.

### 1.2
- Now catches issues when writing to the database and writes them to a fallback driver. [67b0e65](https://github.com/yoeriboven/laravel-log-db/commit/67b0e658dccdc0ec44f3e80734e9535bb9d8cdb2)

### 1.1.1
- Fixed a bug that caused exceptions to report incorrectly [#10](https://github.com/yoeriboven/laravel-log-db/pull/10)

### 1.1
- Added support for Laravel 10

### 1.0.1
- Fixed unguarded model [#2](https://github.com/yoeriboven/laravel-log-db/issues/2)

### 1.0 
Initial version
