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
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('theme_id')->nullable()->constrained('themes')->nullOnDelete();
            $table->string('slug')->unique();
            $table->enum('status', ['trial', 'active', 'expired'])->default('trial');
            $table->timestamp('trial_habis_at')->nullable();
            
            // Mempelai Pria
            $table->string('pria_nama')->nullable();
            $table->string('pria_nama_lengkap')->nullable();
            $table->string('pria_ayah')->nullable();
            $table->string('pria_ibu')->nullable();
            
            // Mempelai Wanita
            $table->string('wanita_nama')->nullable();
            $table->string('wanita_nama_lengkap')->nullable();
            $table->string('wanita_ayah')->nullable();
            $table->string('wanita_ibu')->nullable();
            
            // Settings
            $table->string('cover_img')->nullable();
            $table->string('music_file')->nullable();
            $table->boolean('is_galeri_aktif')->default(true);
            $table->boolean('is_cerita_aktif')->default(false);
            $table->boolean('is_kado_aktif')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
