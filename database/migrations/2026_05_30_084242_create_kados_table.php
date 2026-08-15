<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('undangan_id')->constrained('undangans')->cascadeOnDelete();
            $table->string('nama_bank');
            $table->string('no_rekening');
            $table->string('nama_pemilik');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kados');
    }
};
