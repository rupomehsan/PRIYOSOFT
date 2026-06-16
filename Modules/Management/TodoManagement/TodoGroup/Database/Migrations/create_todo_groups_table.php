<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='/app/Modules/Management/TodoManagement/TodoGroup/Database/create_todo_groups_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('todo_groups', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('todo_milestone_id')->unsigned()->nullable();
            $table->string('name', 200)->nullable();
            $table->string('phase', 100)->nullable();
            $table->integer('sort_order')->nullable();
            $table->integer('cost')->nullable();
            $table->enum('current_status', ['pending','in_progress','completed'])->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
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
        Schema::dropIfExists('todo_groups');
    }
};