<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='/app/Modules/Management/FinanceManagement/Account/Database/create_accounts_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->nullable();
            $table->enum('type', ['cash','bank','mobile_banking','crypto'])->nullable();
            $table->string('account_number', 100)->nullable();
            $table->decimal('opening_balance')->nullable();
            $table->decimal('current_balance')->nullable();
            $table->string('currency', 3)->nullable();
            $table->tinyInteger('is_active')->default(0);
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
        Schema::dropIfExists('accounts');
    }
};