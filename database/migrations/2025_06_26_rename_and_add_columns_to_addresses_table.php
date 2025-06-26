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
        Schema::table('addresses', function (Blueprint $table) {
            // Rename kolom
            $table->renameColumn('address_line1', 'address_line_1');
            $table->renameColumn('address_line2', 'address_line_2');
            // Tambah kolom baru
            $table->string('label')->after('user_id');
            $table->string('recipient_name')->after('label');
            $table->string('phone_number')->after('recipient_name');
            $table->string('courier_notes')->nullable()->after('address_line_2');
            $table->string('pinpoint')->nullable()->after('courier_notes');
            // Hapus kolom yang tidak dipakai
            $table->dropColumn(['city', 'state', 'postal_code', 'country']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            // Kembalikan perubahan jika perlu (opsional)
            $table->renameColumn('address_line_1', 'address_line1');
            $table->renameColumn('address_line_2', 'address_line2');
            $table->dropColumn(['label', 'recipient_name', 'phone_number', 'courier_notes', 'pinpoint']);
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->string('country');
        });
    }
}; 