<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='/app/Modules/Management/WebsiteManagement/HeroSection/Database/create_hero_sections_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->string('badge_text', 100)->nullable();
            $table->string('headline', 300)->nullable();
            $table->string('subheadline', 300)->nullable();
            $table->text('description')->nullable();
            $table->string('primary_button_text', 100)->nullable();
            $table->string('primary_button_url', 100)->nullable();
            $table->string('secondary_button_text', 100)->nullable();
            $table->string('secondary_button_url', 100)->nullable();
            $table->enum('media_type', ['image','video'])->nullable();
            $table->string('background_image', 100)->nullable();
            $table->string('hero_image', 100)->nullable();
            $table->string('video_url', 100)->nullable();
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
        Schema::dropIfExists('hero_sections');
    }
};