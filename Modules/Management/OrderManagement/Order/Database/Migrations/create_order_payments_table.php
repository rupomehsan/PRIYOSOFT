<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * php artisan migrate --path='Modules/Management/OrderManagement/Order/Database/Migrations/create_order_payments_table.php'
     */
    public function up(): void
    {
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->index();

            // Payment method
            $table->enum('payment_method', ['bkash', 'nagad', 'rocket', 'bank', 'card', 'cod'])->nullable();
            $table->enum('account_type', ['Personal', 'Merchant'])->nullable(); // for bKash/Nagad/Rocket

            // Mobile banking & bank transfer
            $table->string('sender_number', 20)->nullable();       // caller's number
            $table->string('transaction_id', 200)->nullable();
            $table->decimal('amount', 15, 2)->default(0);

            // Card / gateway
            $table->string('card_gateway', 50)->nullable();        // sslcommerz, stripe, paypal
            $table->string('gateway_transaction_id', 200)->nullable();
            $table->enum('gateway_mode', ['sandbox', 'live'])->default('live');

            // Proof
            $table->string('screenshot', 500)->nullable();         // uploaded payment screenshot path

            // Status lifecycle
            $table->enum('status', ['pending', 'submitted', 'verified', 'rejected'])->default('pending');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->string('rejection_reason', 500)->nullable();

            // Notes
            $table->text('note')->nullable();

            // System
            $table->unsignedBigInteger('creator')->nullable();
            $table->string('slug', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};
