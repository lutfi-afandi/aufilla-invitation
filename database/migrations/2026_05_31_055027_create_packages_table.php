<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->decimal('price', 10, 2);
            $table->integer('active_days');
            $table->integer('max_gallery_photos')->default(0);
            $table->boolean('has_love_story')->default(false);
            $table->boolean('can_custom_music')->default(false);
            $table->boolean('is_priority_support')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
