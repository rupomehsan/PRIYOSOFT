<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='/app/Modules/Management/OrderManagement/Order/Database/create_orders_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 50)->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('customer_id')->nullable();
            $table->string('plan_name', 200)->nullable();
            $table->enum('billing_cycle', ['monthly','yearly','one_time'])->nullable();
            $table->enum('order_status', ['pending_payment','payment_submitted','payment_verified','access_sent','cancelled','refunded'])->nullable();
            $table->enum('delivery_method', ['email','manual_contact'])->nullable();
            $table->decimal('subtotal', 15, 2)->nullable();
            $table->decimal('discount_amount', 15, 2)->nullable();
            $table->decimal('total_amount', 15, 2)->nullable();
            $table->string('coupon_code', 100)->nullable();
            $table->text('customer_note')->nullable();
            $table->datetime('ordered_at')->nullable();
            $table->datetime('payment_verified_at')->nullable();
            $table->datetime('access_sent_at')->nullable();
            $table->datetime('cancelled_at')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->enum('status', ['active','inactive'])->nullable();
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
        Schema::dropIfExists('orders');
    }
};