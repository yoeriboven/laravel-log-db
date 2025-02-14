<?php

namespace Yoeriboven\LaravelLogDb;

use Exception;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Throwable;
use Yoeriboven\LaravelLogDb\Models\LogMessage;

class DatabaseHandler extends AbstractProcessingHandler
{
    /**
     * @inheritDoc
     */
    protected function write($record): void
    {
        $record = is_array($record) ? $record : $record->toArray();

        if ($this->hasMinimumLevelSet() && ! $this->meetsLevelThreshold($record['level'])) {
            return;
        }

        $exception = $record['context']['exception'] ?? null;

        if ($exception instanceof Throwable) {
            $record['context']['exception'] = (string) $exception;
        }

        try {
            LogMessage::create([
                'level' => $record['level'],
                'level_name' => $record['level_name'],
                'message' => $record['message'],
                'logged_at' => $record['datetime'],
                'context' => $record['context'],
                'extra' => $record['extra'],
            ]);
        } catch (Exception $e) {
            $fallbackChannels = config('logging.channels.fallback.channels', ['single']);

            Log::stack($fallbackChannels)->debug($record['formatted'] ?? $record['message']);

            Log::stack($fallbackChannels)->debug('Could not log to the database.', [
                'exception' => $e,
            ]);
        }
    }

    public function hasMinimumLevelSet()
    {
        return config('logging.channels.db.level') !== null;
    }

    public function meetsLevelThreshold(int $currentLevel): bool
    {
        $minimumLevel = Logger::toMonologLevel(config('logging.channels.db.level'));

        if (! is_int($minimumLevel)) {
            $minimumLevel = $minimumLevel->value;
        }

        return $currentLevel >= $minimumLevel;
    }
}
