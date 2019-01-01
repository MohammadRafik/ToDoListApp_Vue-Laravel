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
            $table->increments('Tableid');
            $table->integer('id');
            $table->string('task');
            $table->string('description');
            $table->bigInteger('timeWorked');
            $table->string('workDoneMessage');
            $table->boolean('toggleMode');
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
