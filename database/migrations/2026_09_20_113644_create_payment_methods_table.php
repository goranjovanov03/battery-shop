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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Stripe", "PayPal", "NLB Bank"
            $table->string('slug')->unique(); // e.g., "stripe", "paypal", "nlb_bank"
            $table->string('type'); // stripe, paypal, bank_transfer, cash_on_delivery
            $table->text('description')->nullable();
            $table->json('config')->nullable(); // API keys, merchant IDs, etc.
            $table->json('supported_currencies')->nullable(); // ['MKD', 'EUR', 'USD']
            $table->json('supported_countries')->nullable(); // ['MK', 'US', etc.]
            $table->decimal('min_amount', 10, 2)->nullable();
            $table->decimal('max_amount', 10, 2)->nullable();
            $table->decimal('fee_percentage', 5, 2)->default(0);
            $table->decimal('fee_fixed', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_sandbox')->default(false);
            $table->integer('sort_order')->default(0);
            $table->string('icon')->nullable(); // icon class or path
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};