<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='/Modules/Management/FinanceManagement/Database/Migrations/create_profit_distribution_items_table.php' 
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profit_distribution_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('profit_distribution_id')->nullable();
            $table->enum('recipient_type', ['owner','investor'])->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('investor_id')->nullable();
            $table->decimal('percentage')->nullable();
            $table->decimal('amount')->nullable();
            $table->bigInteger('withdrawal_id')->nullable();
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
        Schema::dropIfExists('profit_distribution_items');
    }
};