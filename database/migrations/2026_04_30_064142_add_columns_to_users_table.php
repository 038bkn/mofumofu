<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Apply schema modifications to the `users` table when the migration is run.
     *
     * This method defines the alterações to the `users` table schema; currently the schema-change block is empty and no modifications are applied.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverts schema changes on the `users` table.
     *
     * Currently this migration defines no schema operations, so running `down` will not modify the table.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
