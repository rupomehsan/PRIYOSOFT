<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='/app/Modules/Management/FinanceManagement/AccountTransfer/Database/create_account_transfers_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('account_transfers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('from_account_id')->nullable();
            $table->bigInteger('to_account_id')->nullable();
            $table->decimal('amount')->nullable();
            $table->decimal('fee')->nullable();
            $table->date('transferred_at')->nullable();
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
        Schema::dropIfExists('account_transfers');
    }
};