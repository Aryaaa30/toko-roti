<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->text('notes')->nullable()->after('quantity');
            $table->unsignedBigInteger('address_id')->nullable()->after('notes');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['address_id']);
            $table->dropColumn(['notes', 'address_id']);
        });
    }
}; 