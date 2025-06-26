<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('label')->nullable()->change();
            $table->string('recipient_name')->nullable()->change();
            $table->string('phone_number')->nullable()->change();
            $table->string('courier_notes')->nullable()->change();
            $table->string('pinpoint')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('label')->nullable(false)->change();
            $table->string('recipient_name')->nullable(false)->change();
            $table->string('phone_number')->nullable(false)->change();
            $table->string('courier_notes')->nullable(false)->change();
            $table->string('pinpoint')->nullable(false)->change();
        });
    }
}; 