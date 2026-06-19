<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * php artisan migrate --path='Modules/Management/OrderManagement/Order/Database/Migrations/create_order_status_histories_table.php'
     */
    public function up(): void
    {
        Schema::create('order_status_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->index();

            $table->string('from_status', 100)->nullable();
            $table->string('to_status', 100)->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('changed_by')->nullable();

            $table->unsignedBigInteger('creator')->nullable();
            $table->string('slug', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_status_histories');
    }
};
