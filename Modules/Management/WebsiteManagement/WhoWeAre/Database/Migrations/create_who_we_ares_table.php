<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='/app/Modules/Management/WebsiteManagement/WhoWeAre/Database/create_who_we_ares_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('who_we_ares', function (Blueprint $table) {
            $table->id();
            $table->string('badge_label', 100)->nullable();
            $table->string('title', 300)->nullable();
            $table->string('experience')->nullable();
            $table->text('description')->nullable();
            $table->string('image', 100)->nullable();
            $table->json('features')->nullable();
            $table->json('stats')->nullable();
            $table->integer('sort_order')->nullable();
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
        Schema::dropIfExists('who_we_ares');
    }
};