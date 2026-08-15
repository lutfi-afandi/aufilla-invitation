<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expired_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamp('executed_at');
            $table->integer('total_expired')->default(0);
            $table->json('affected_invitations')->nullable();
            $table->string('status')->default('success');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expired_logs');
    }
};
