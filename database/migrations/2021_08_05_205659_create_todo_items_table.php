<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todo_items', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->text('body');
            $table->date('due_date')->nullable();
            $table->boolean('has_reminder')->default(false);
            $table->datetime('reminder_date')->nullable();
            $table->enum('status', ['complete', 'incomplete'])->default('incomplete')->index();
            $table->boolean('reminder_sent')->default(false);
            $table->timestamps();

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todo_items');
    }
}
