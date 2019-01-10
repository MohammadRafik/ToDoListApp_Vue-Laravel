<?php

namespace App\Http\Controllers;

use App\TaskData;
use Illuminate\Http\Request;

class TaskDataController extends Controller
{
    //

    public function create(Request $request){
        //get the user.id of the creator of this task
        $userID = \Auth::user()->id;

        //get data from JS
        $taskDataFromJS = $request->all();

        //save new task into taskdata table
        
        TaskData::create([
            'user_id' => $userID,
            'task' => $taskDataFromJS['task'],
            'description' => $taskDataFromJS['description'],
            'timeWorked' => $taskDataFromJS['timeWorked'],
            'workDoneMessage' => $taskDataFromJS['workDoneMessage'],
            'toggleMode' => $taskDataFromJS['toggleMode'],
            'workTimeUpdateCheck' => $taskDataFromJS['workTimeUpdateCheck'],
            'playAndPauseButtonSymbole' => $taskDataFromJS['playAndPauseButtonSymbole'],
            'taskCompleted' => $taskDataFromJS['taskCompleted'],
            'color' => $taskDataFromJS['color'],

        ]);


    }

    public function update(TaskData $taskData){

    }


}
