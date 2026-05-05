<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the `owned_items` table with id, owner/item foreign keys, an equipped flag, and timestamps.
     *
     * The `user_id` and `item_id` columns are constrained as foreign keys and cascade on delete.
     * The `is_equipped` column is a boolean that defaults to `false` and includes the comment '装備中フラグ'.
     */
    public function up(): void
    {
        Schema::create('owned_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_equipped')->default(false)->comment('装備中フラグ');
            $table->timestamps();
        });
    }

    /**
     * Drop the `owned_items` table if it exists.
     */
    public function down(): void
    {
        Schema::dropIfExists('owned_items');
    }
};
