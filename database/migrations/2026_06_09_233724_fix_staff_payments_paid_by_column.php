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
    Schema::table('staff_payments', function (Blueprint $table) {
        $table->dropForeign(['paid_by']);
        // plain integer, no FK — stores admin id freely
        $table->unsignedBigInteger('paid_by')->nullable()->change();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
