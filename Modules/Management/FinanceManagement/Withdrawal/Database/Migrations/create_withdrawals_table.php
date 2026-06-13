<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='/app/Modules/Management/FinanceManagement/Withdrawal/Database/create_withdrawals_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->enum('withdrawn_by_type', ['owner','investor'])->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('investor_id')->nullable();
            $table->bigInteger('account_id')->nullable();
            $table->decimal('amount')->nullable();
            $table->string('currency', 3)->nullable();
            $table->string('reason', 300)->nullable();
            $table->date('withdrawn_at')->nullable();
            $table->string('attachment', 100)->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('withdrawals');
    }
};