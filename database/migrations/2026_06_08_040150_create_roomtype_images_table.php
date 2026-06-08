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
        if (!Schema::hasTable('roomtype_images')) {
            Schema::create('roomtype_images', function (Blueprint $table) {
                $table->id();
                $table->foreignId('room_type_id')->constrained()->onDelete('cascade');
                $table->string('image_path');
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('roomtype_images');
    }
};
