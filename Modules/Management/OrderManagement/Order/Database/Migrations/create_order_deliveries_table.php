<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * php artisan migrate --path='Modules/Management/OrderManagement/Order/Database/Migrations/create_order_deliveries_table.php'
     */
    public function up(): void
    {
        Schema::create('order_deliveries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->index();

            $table->enum('method', ['email', 'whatsapp', 'manual_contact'])->nullable();
            $table->string('contact_via', 150)->nullable();        // phone/email used
            $table->string('recipient_email', 200)->nullable();
            $table->string('subject', 300)->nullable();
            $table->text('message')->nullable();
            $table->string('attachment', 500)->nullable();

            $table->unsignedBigInteger('sent_by')->nullable();
            $table->timestamp('delivered_at')->nullable();

            $table->unsignedBigInteger('creator')->nullable();
            $table->string('slug', 50)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_deliveries');
    }
};
