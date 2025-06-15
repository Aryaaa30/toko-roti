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
        Schema::table('menus', function (Blueprint $table) {
            // Ubah tipe kolom 'images' menjadi LONGTEXT agar bisa menampung data JSON path gambar yang panjang
            $table->longText('images')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            // Kembalikan ke tipe sebelumnya jika rollback
            $table->string('images', 255)->nullable()->change();
        });
    }
};