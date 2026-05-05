<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the `soliloquies` table with its schema.
     *
     * The table includes an auto-incrementing `id`, a `user_id` foreign key that references the related users table and cascades on delete, a `content` TEXT column (comment: "つぶやき内容"), a `type` TINYINT column defaulting to 0 with values `0:通常`, `1:ほめて`, `2:なぐさめて`, and Laravel-managed `created_at` / `updated_at` timestamps.
     */
    public function up(): void
    {
        Schema::create('soliloquies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('content')->comment('つぶやき内容');
            $table->tinyInteger('type')->default(0)->comment('0:通常, 1:ほめて, 2:なぐさめて');
            $table->timestamps();
        });
    }

    /**
     * Drop the `soliloquies` table if it exists.
     */
    public function down(): void
    {
        Schema::dropIfExists('soliloquies');
    }
};
