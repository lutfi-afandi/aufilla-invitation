<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tamus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('undangan_id')->constrained('undangans')->cascadeOnDelete();
            $table->string('nama_tamu');
            $table->string('slug');
            $table->string('no_whatsapp')->nullable();
            $table->string('kode_qr')->nullable();
            $table->boolean('is_wa_sent')->default(false);
            $table->timestamp('waktu_hadir')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tamus');
    }
};
