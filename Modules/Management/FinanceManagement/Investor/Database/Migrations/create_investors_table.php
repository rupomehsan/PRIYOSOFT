<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='/app/Modules/Management/FinanceManagement/Investor/Database/create_investors_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('investors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->nullable();
            $table->string('email', 200)->nullable();
            $table->string('phone', 50)->nullable();
            $table->text('address')->nullable();
            $table->string('nid_or_passport', 100)->nullable();
            $table->enum('type', ['individual','company'])->nullable();
            $table->decimal('equity_percentage')->nullable();
            $table->text('note')->nullable();
            $table->date('joined_at')->nullable();
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
        Schema::dropIfExists('investors');
    }
};