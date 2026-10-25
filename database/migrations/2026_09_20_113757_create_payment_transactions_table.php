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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_method_id')->constrained()->onDelete('cascade');
            $table->string('transaction_id')->unique(); // External transaction ID
            $table->string('reference')->nullable(); // Our internal reference
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('MKD');
            $table->string('status'); // pending, processing, completed, failed, refunded, cancelled
            $table->json('gateway_response')->nullable(); // Full response from gateway
            $table->json('metadata')->nullable(); // Additional data
            $table->string('error_message')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->index(['order_id', 'status']);
            $table->index('transaction_id');
            $table->index('reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};