<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='/Modules/Management/OrderManagement/Order/Database/Migrations/create_order_deliveries_table.php' 
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_deliveries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->nullable();
            $table->enum('method', ['email','manual_contact'])->nullable();
            $table->string('contact_via', 100)->nullable();
            $table->string('recipient_email', 200)->nullable();
            $table->string('subject', 300)->nullable();
            $table->text('message')->nullable();
            $table->string('attachment', 100)->nullable();
            $table->bigInteger('sent_by')->nullable();
            $table->datetime('delivered_at')->nullable();
                    $table->bigInteger('creator')->unsigned()->nullable();
                    $table->string('slug', 50)->nullable();
                    $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_deliveries');
    }
};