<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Since we need to convert from string to text and don't have doctrine/dbal,
        // we'll install it via composer command
        if (!Schema::hasColumn('menus', 'images')) {
            // If the column doesn't exist, just add it
        Schema::table('menus', function (Blueprint $table) {
            $table->text('images')->nullable();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse anything in this case
    }
};