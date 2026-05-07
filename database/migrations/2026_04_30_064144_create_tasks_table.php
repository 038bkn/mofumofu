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
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
