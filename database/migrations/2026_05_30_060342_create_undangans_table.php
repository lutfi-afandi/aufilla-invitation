<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('undangans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tema_id')->nullable()->constrained('temas')->nullOnDelete();
            $table->foreignId('paket_id')->nullable()->constrained('pakets')->nullOnDelete();
            $table->string('slug')->unique();
            $table->enum('status', ['aktif', 'kedaluwarsa'])->default('aktif');
            $table->timestamp('expired_at')->nullable();
            
            // Mempelai Pria
            $table->string('pria_nama')->nullable();
            $table->string('pria_nama_lengkap')->nullable();
            $table->string('pria_ayah')->nullable();
            $table->string('pria_ibu')->nullable();
            $table->string('pria_foto')->nullable();
            
            // Mempelai Wanita
            $table->string('wanita_nama')->nullable();
            $table->string('wanita_nama_lengkap')->nullable();
            $table->string('wanita_ayah')->nullable();
            $table->string('wanita_ibu')->nullable();
            $table->string('wanita_foto')->nullable();

            // Kutipan
            $table->string('kutipan_sumber')->nullable();
            $table->text('kutipan_teks')->nullable();
            
            // Settings
            $table->string('cover_img')->nullable();
            $table->string('music_file')->nullable();
            $table->boolean('is_galeri_aktif')->default(true);
            $table->boolean('is_cerita_aktif')->default(false);
            $table->boolean('is_kado_aktif')->default(true);
            $table->text('alamat_kado')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('undangans');
    }
};
