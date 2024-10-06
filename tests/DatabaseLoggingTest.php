<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Yoeriboven\LaravelLogDb\DatabaseLogger;
use Yoeriboven\LaravelLogDb\Models\LogMessage;

uses(\Illuminate\Foundation\Testing\DatabaseMigrations::class);

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

it('correctly logs exceptions', function () {
    config()->set('logging.default', 'db');

    report(new Exception('This exception should be logged.'));

    $this->assertStringContainsString(
        'This exception should be logged.',
        LogMessage::first()->context['exception']
    );
});
