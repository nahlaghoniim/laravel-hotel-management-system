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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->nullable()->constrained('rooms')->onDelete('set null');
            $table->foreignId('room_type_id')->nullable()->constrained('room_types')->onDelete('set null');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default('reserved'); // reserved, checked_in, checked_out, cancelled
            $table->string('payment_status')->default('pending'); // pending, paid, refunded
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('currency', 8)->default('USD');
            $table->unsignedSmallInteger('adults')->default(1);
            $table->unsignedSmallInteger('children')->default(0);
            $table->text('notes')->nullable();
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('checked_out_at')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
