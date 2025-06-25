<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE menus MODIFY kategori ENUM('Roti Manis', 'Roti Tawar', 'Kue (Cake)', 'Donat', 'Pastry', 'birthday') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE menus MODIFY kategori ENUM('Roti Manis', 'Roti Tawar', 'Kue (Cake)', 'Donat', 'Pastry') NOT NULL");
    }
};
