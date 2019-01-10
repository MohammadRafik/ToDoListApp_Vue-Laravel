<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('task')->nullable();
            $table->string('description')->nullable();
            $table->bigInteger('timeWorked');
            $table->string('workDoneMessage');
            $table->boolean('toggleMode');
            $table->integer('workTimeUpdateCheck')->nullable();
            $table->string('playAndPauseButtonSymbole');
            $table->boolean('taskCompleted');
            $table->string('color');
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
        Schema::dropIfExists('task_datas');
    }
}
