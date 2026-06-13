<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='/app/Modules/Management/WebsiteManagement/TeamMember/Database/create_team_members_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->nullable();
            $table->string('role', 200)->nullable();
            $table->text('bio')->nullable();
            $table->string('photo', 100)->nullable();
            $table->string('linkedin', 500)->nullable();
            $table->string('github', 500)->nullable();
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
        Schema::dropIfExists('team_members');
    }
};