<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acaras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('undangan_id')->constrained('undangans')->cascadeOnDelete();
            $table->string('nama_acara')->nullable();
            $table->enum('tipe_acara', ['akad', 'resepsi']);
            $table->date('tgl_acara')->nullable();
            $table->time('waktu_mulai')->nullable();
            $table->time('waktu_selesai')->nullable();
            $table->string('lokasi')->nullable();
            $table->text('alamat')->nullable();
            $table->text('gmaps_link')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acaras');
    }
};
