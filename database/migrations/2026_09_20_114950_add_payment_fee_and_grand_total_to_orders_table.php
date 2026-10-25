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
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('payment_fee', 10, 2)->default(0)->after('total');
            $table->decimal('grand_total', 12, 2)->default(0)->after('payment_fee');
            $table->string('currency', 3)->default('MKD')->after('grand_total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_fee', 'grand_total', 'currency']);
        });
    }
};