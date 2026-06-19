<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * php artisan migrate --path='Modules/Management/OrderManagement/Order/Database/Migrations/create_orders_table.php'
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 50)->unique()->nullable();

            // Product reference
            $table->unsignedBigInteger('product_id')->nullable()->index();
            $table->string('product_name', 255)->nullable();      // snapshot at order time
            $table->string('plan_name', 200)->nullable();
            $table->enum('billing_cycle', ['monthly', 'yearly', 'one_time'])->default('one_time');

            // Guest customer info (no login required)
            $table->unsignedBigInteger('customer_id')->nullable(); // if logged in
            $table->string('customer_name', 150)->nullable();
            $table->string('customer_phone', 20)->nullable();
            $table->string('customer_email', 150)->nullable();

            // Project details (from Payment form)
            $table->string('domain_name', 255)->nullable();
            $table->text('project_description')->nullable();
            $table->date('preferred_delivery_date')->nullable();
            $table->text('special_requirements')->nullable();       // form.message

            // Pricing
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->string('coupon_code', 100)->nullable();

            // Payment preference
            $table->boolean('pay_now')->default(false);            // toggle switch
            $table->enum('payment_method', ['bkash', 'nagad', 'rocket', 'bank', 'card', 'cod'])->nullable();

            // Order lifecycle
            $table->enum('order_status', [
                'pending_payment',
                'payment_submitted',
                'payment_verified',
                'in_progress',
                'access_sent',
                'completed',
                'cancelled',
                'refunded',
            ])->default('pending_payment');

            $table->enum('delivery_method', ['email', 'manual_contact', 'whatsapp'])->nullable();

            // Timestamps for lifecycle events
            $table->timestamp('ordered_at')->nullable();
            $table->timestamp('payment_verified_at')->nullable();
            $table->timestamp('work_started_at')->nullable();
            $table->timestamp('access_sent_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            // Admin / system
            $table->text('admin_note')->nullable();
            $table->string('ref_code', 30)->nullable();            // PFC-XXXXXXXX shown on success
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('slug', 50)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
