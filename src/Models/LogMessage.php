<?php

namespace Yoeriboven\LaravelLogDb\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;

class LogMessage extends Model
{
    use MassPrunable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'context' => AsArrayObject::class,
        'extra' => AsArrayObject::class,
        'logged_at' => 'immutable_datetime',
    ];

    public function getConnectionName(): string
    {
        return $this->connection ?: config('logging.channels.db.connection') ?: config('database.default');
    }

    /**
     * Get the prunable model query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function prunable()
    {
        return static::where('logged_at', '<=', now()->subDays(config('logging.channels.db.days')));
    }
}
