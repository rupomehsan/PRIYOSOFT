<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='/app/Modules/Management/FinanceManagement/Income/Database/create_incomes_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->string('title', 300)->nullable();
            $table->bigInteger('income_category_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('account_id')->nullable();
            $table->decimal('amount')->nullable();
            $table->string('currency', 3)->nullable();
            $table->string('source', 200)->nullable();
            $table->date('received_at')->nullable();
            $table->string('invoice_no', 100)->nullable();
            $table->text('note')->nullable();
            $table->string('attachment', 100)->nullable();
            $table->bigInteger('created_by')->nullable();
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
        Schema::dropIfExists('incomes');
    }
};