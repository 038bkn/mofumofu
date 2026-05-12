<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->time('start_time')->nullable()->after('due_date')->comment('開始時刻');
            $table->time('end_time')->nullable()->after('start_time')->comment('終了時刻');
            $table->text('note')->nullable()->after('end_time')->comment('メモ');
            $table->string('location')->nullable()->after('note')->comment('場所');
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['start_time', 'end_time', 'note', 'location']);
        });
    }
};
