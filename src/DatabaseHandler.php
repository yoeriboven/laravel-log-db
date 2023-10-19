<?php

namespace Yoeriboven\LaravelLogDb;

use Illuminate\Support\Facades\DB;
use Monolog\Handler\AbstractProcessingHandler;
use Throwable;
use Yoeriboven\LaravelLogDb\Models\LogMessage;

class DatabaseHandler extends AbstractProcessingHandler
{
    /**
     * @inheritDoc
     */
    protected function write($record): void
    {
        if (!app()->isBooted()) {
            return; // Exit early if the app isn't booted
        }
        if (!$this->isDatabaseReady()) {
            return; // Exit early if the database isn't ready
        }
        $record = is_array($record) ? $record : $record->toArray();

        $exception = $record['context']['exception'] ?? null;

        if ($exception instanceof Throwable) {
            $record['context']['exception'] = (string) $exception;
        }

        LogMessage::create([
            'level' => $record['level'],
            'level_name' => $record['level_name'],
            'message' => $record['message'],
            'logged_at' => $record['datetime'],
            'context' => $record['context'],
            'extra' => $record['extra'],
        ]);
    }
    private function isDatabaseReady(): bool
    {
        $isReady = false;

            try {
                DB::connection()->getPdo();
                $isReady = true;
            } catch (\Exception $e) {
                $isReady = false;
            }

        return $isReady;
    }
}
