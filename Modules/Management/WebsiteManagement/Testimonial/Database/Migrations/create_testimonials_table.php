<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='/app/Modules/Management/WebsiteManagement/Testimonial/Database/create_testimonials_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('client_name', 200)->nullable();
            $table->string('client_company', 200)->nullable();
            $table->enum('media_type', ['image','video'])->nullable();
            $table->string('client_photo', 100)->nullable();
            $table->string('video_url', 100)->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->integer('rating')->nullable();
            $table->text('message')->nullable();
            $table->tinyInteger('is_featured')->default(0);
            $table->tinyInteger('is_visible')->default(0);
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
        Schema::dropIfExists('testimonials');
    }
};