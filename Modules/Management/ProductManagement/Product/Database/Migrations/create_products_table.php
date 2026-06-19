<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='/app/Modules/Management/ProductManagement/Product/Database/create_products_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_group_id')->nullable();
            $table->string('name', 200)->nullable();
            $table->string('slug', 200)->nullable();
            $table->text('description')->nullable();
            $table->string('thumbnail', 200)->nullable();
            $table->string('promo_link', 500)->nullable();
            $table->enum('project_status', ['planning','development','active','paused'])->nullable();
              $table->string('version', 50)->nullable()->default('v1.0.0');$table->string('video_url', 500)->nullable();
            $table->date('launch_date')->nullable();
            $table->decimal('monthly_target_revenue', 12, 2)->nullable();
            $table->decimal('regular_price', 12, 2)->nullable();
            $table->decimal('sales_price', 12, 2)->nullable();
            $table->json('features')->nullable();
            $table->text('screenshots')->nullable();
             $table->enum('status', ['active', 'inactive'])->default('active');
                    $table->bigInteger('creator')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};