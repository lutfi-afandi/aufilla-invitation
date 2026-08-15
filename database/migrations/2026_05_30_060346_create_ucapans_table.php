<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ucapans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('undangan_id')->constrained('undangans')->cascadeOnDelete();
            $table->string('nama');
            $table->text('ucapan');
            $table->enum('kehadiran', ['hadir', 'tidak_hadir', 'ragu'])->default('hadir');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ucapans');
    }
};
