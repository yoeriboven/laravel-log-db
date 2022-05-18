<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Yoeriboven\LaravelLogDb\DatabaseLogger;

uses(RefreshDatabase::class);

beforeEach(function () {
    config()->set('logging.channels.db', [
        'driver' => 'custom',
        'via' => DatabaseLogger::class,
    ]);
});

it('logs to the database', function () {
    Log::channel('db')->info('Test message');

    $this->assertDatabaseHas('log_messages', [
        'level_name' => mb_strtoupper('info'),
        'message' => 'Test message',
    ]);
});

it('stores the logs context', function () {
    Log::channel('db')->info('Test message', ['user_id' => 999]);

    $this->assertDatabaseHas('log_messages', [
        'context' => json_encode(['user_id' => 999]),
    ]);
});
