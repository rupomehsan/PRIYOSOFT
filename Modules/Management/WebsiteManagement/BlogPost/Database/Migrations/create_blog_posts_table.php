<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='/app/Modules/Management/WebsiteManagement/BlogPost/Database/create_blog_posts_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 500)->nullable();
            $table->string('slug', 500)->nullable();
            $table->string('thumbnail', 100)->nullable();
            $table->text('excerpt')->nullable();
            $table->longtext('body')->nullable();
            $table->bigInteger('author_id')->nullable();
            $table->bigInteger('product_id')->nullable();
             $table->enum('status', ['active', 'inactive'])->default('active');
            $table->datetime('published_at')->nullable();
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
        Schema::dropIfExists('blog_posts');
    }
};