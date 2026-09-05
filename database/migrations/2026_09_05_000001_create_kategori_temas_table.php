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
        Schema::create('kategori_temas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('slug', 100)->unique();
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('temas', function (Blueprint $table) {
            $table->foreignId('kategori_tema_id')
                ->nullable()
                ->after('category')
                ->constrained('kategori_temas')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temas', function (Blueprint $table) {
            $table->dropForeign(['kategori_tema_id']);
            $table->dropColumn('kategori_tema_id');
        });

        Schema::dropIfExists('kategori_temas');
    }
};
