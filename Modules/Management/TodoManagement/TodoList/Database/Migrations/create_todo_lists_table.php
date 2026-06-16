<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     php artisan migrate --path='/app/Modules/Management/TodoManagement/TodoList/Database/create_todo_lists_table.php'
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('todo_lists', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('todo_group_id')->nullable();
            $table->string('title', 400)->nullable();
            $table->string('assigned_to', 100)->nullable();
            $table->decimal('estimated_days')->nullable();
            $table->decimal('daily_rate')->nullable();
            $table->decimal('fixed_cost')->nullable();
            $table->decimal('item_cost')->nullable();
            $table->tinyInteger('is_recurring')->default(0);
            $table->enum('priority', ['critical','high','medium','low'])->nullable();
            $table->enum('current_status', ['pending','in_progress','completed','skipped'])->nullable();
            $table->date('completed_at')->nullable();
            $table->text('note')->nullable();
            $table->integer('sort_order')->nullable();
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
        Schema::dropIfExists('todo_lists');
    }
};