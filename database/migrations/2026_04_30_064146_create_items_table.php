<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the `items` database table.
     *
     * The table will include the following columns:
     * - `id`: auto-incrementing primary key.
     * - `name`: item name (comment: `アイテム名`).
     * - `category`: category string (max 50 characters, e.g., `character`, `clothing`).
     * - `price`: required points (comment: `必要ポイント`).
     * - `image_path`: path to the item's image (comment: `画像パス`).
     * - `created_at` and `updated_at` timestamps.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('アイテム名');
            $table->string('category', 50)->comment('カテゴリ(character, clothing等)');
            $table->integer('price')->comment('必要ポイント');
            $table->string('image_path')->comment('画像パス');
            $table->timestamps();
        });
    }

    /**
     * Reverts the migration by dropping the `items` table if it exists.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
