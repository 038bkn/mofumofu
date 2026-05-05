<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the `tasks` database table used to store user tasks and their metadata.
     *
     * The table includes:
     * - `id`: auto-incrementing primary key.
     * - `user_id`: foreign key to `users`, cascades on delete.
     * - `title`: task title (comment: タスク内容).
     * - `difficulty`: difficulty level 1–5 (tiny integer, comment: 難易度1〜5).
     * - `status`: tiny integer with default `0` (0:未完了, 1:完了).
     * - `due_date`: nullable date for the task deadline (comment: 期限日).
     * - `completed_at`: nullable timestamp for completion time (comment: 完了日時).
     * - `created_at` and `updated_at` timestamps.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title')->comment('タスク内容');
            $table->tinyInteger('difficulty')->comment('難易度1〜5');
            $table->tinyInteger('status')->default(0)->comment('0:未完了, 1:完了');
            $table->date('due_date')->nullable()->comment('期限日');
            $table->timestamp('completed_at')->nullable()->comment('完了日時');
            $table->timestamps();
        });
    }

    /**
     * Drop the `tasks` table if it exists.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
