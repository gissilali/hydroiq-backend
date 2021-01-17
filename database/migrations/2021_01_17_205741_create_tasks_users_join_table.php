<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksUsersJoinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks_users_join', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assigned_by');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('task_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks_users_join');
    }
}
