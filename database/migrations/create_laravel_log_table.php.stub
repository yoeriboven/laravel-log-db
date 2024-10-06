<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $connection = config('logging.channels.db.connection') ?? config('database.default');

        Schema::connection($connection)->create('log_messages', function (Blueprint $table) {
            $table->id();
            $table->string('level_name');
            $table->unsignedSmallInteger('level');
            $table->string('message');
            $table->dateTime('logged_at');
            $table->json('context');
            $table->json('extra');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_messages');
    }
};
