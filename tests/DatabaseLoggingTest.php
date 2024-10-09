<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Yoeriboven\LaravelLogDb\DatabaseLogger;
use Yoeriboven\LaravelLogDb\Models\LogMessage;

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

it('correctly logs exceptions', function () {
    config()->set('logging.default', 'db');

    report(new Exception('This exception should be logged.'));

    $this->assertStringContainsString(
        'This exception should be logged.',
        LogMessage::first()->context['exception']
    );
});

it('uses the default connection if no custom connection is set', function () {
    $model = new LogMessage();

    expect(config('database.default'))->toEqual($model->getConnectionName());
});

it('uses the custom connection if it is set', function () {
    config()->set('logging.channels.db.connection', 'custom');

    $model = new LogMessage();

    expect(config('logging.channels.db.connection'))->toEqual($model->getConnectionName());
});

it('logs to the correct connection', function () {
    config()->set('logging.channels.db.connection', 'custom');

    Log::channel('db')->info('Test message');

    $this->assertDatabaseHas('log_messages', [
        'level_name' => mb_strtoupper('info'),
        'message' => 'Test message',
    ], 'custom');
});

it('prunes old logs', function () {
    config()->set('logging.channels.db.days', 7);

    $message = LogMessage::create([
        'level' => 200,
        'level_name' => 'INFO',
        'message' => 'Test message',
        'logged_at' => now()->subDays(7),
        'context' => [],
        'extra' => [],
    ]);

    Artisan::call('model:prune', [
        '--model' => [
            LogMessage::class,
        ]
    ]);

    expect($message->fresh())->toBeNull();
});

it('doesnt prune new logs', function () {
    config()->set('logging.channels.db.days', 7);

    $message = LogMessage::create([
        'level' => 200,
        'level_name' => 'INFO',
        'message' => 'Test message',
        'logged_at' => now()->subDays(7)->addSecond(),
        'context' => [],
        'extra' => [],
    ]);

    Artisan::call('model:prune', [
        '--model' => [
            LogMessage::class,
        ]
    ]);

    expect($message->fresh())->not->toBeNull();
});