<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='/Modules/Management/OrderManagement/Order/Database/Migrations/create_order_payments_table.php' 
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->nullable();
            $table->enum('payment_method', ['bkash','nagad','bank_transfer','card'])->nullable();
            $table->string('sender_number', 20)->nullable();
            $table->string('transaction_id', 200)->nullable();
            $table->decimal('amount')->nullable();
            $table->enum('status', ['submitted','verified','rejected'])->nullable();
            $table->datetime('submitted_at')->nullable();
            $table->datetime('verified_at')->nullable();
            $table->bigInteger('verified_by')->nullable();
            $table->string('rejection_reason', 300)->nullable();
            $table->string('screenshot', 100)->nullable();
            $table->text('note')->nullable();
                    $table->bigInteger('creator')->unsigned()->nullable();
                    $table->string('slug', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};