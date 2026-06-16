<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='/app/Modules/Management/TodoManagement/TodoMilestone/Database/create_todo_milestones_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('todo_milestones', function (Blueprint $table) {
            $table->id();
            $table->string('title', 300)->nullable();
            $table->string('phase', 100)->nullable();
            $table->date('target_date')->nullable();
            $table->date('achieved_date')->nullable();
            $table->enum('current_status', ['upcoming','achieved','missed'])->nullable();
            $table->text('note')->nullable();
            $table->integer('sort_order')->nullable();
            $table->integer('cost')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active')->nullable();
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
        Schema::dropIfExists('todo_milestones');
    }
};