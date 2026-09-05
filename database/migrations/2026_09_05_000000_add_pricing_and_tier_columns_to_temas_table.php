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
        Schema::table('temas', function (Blueprint $table) {
            $table->enum('tingkatan', ['standar', 'premium', 'eksklusif'])->default('standar')->after('category');
            $table->decimal('harga_tambahan', 10, 2)->default(0)->after('tingkatan');
            $table->boolean('is_privat')->default(false)->after('harga_tambahan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temas', function (Blueprint $table) {
            $table->dropColumn(['tingkatan', 'harga_tambahan', 'is_privat']);
        });
    }
};
