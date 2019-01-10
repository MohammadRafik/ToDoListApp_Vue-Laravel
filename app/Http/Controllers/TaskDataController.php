<?php

namespace App\Http\Controllers;

use App\TaskData;
use Illuminate\Http\Request;

class TaskDataController extends Controller
{
    
    public function loadHomePage(){

        return view('FrontPage');
    }

    public function create(Request $request){
        //get the user.id of the creator of this task
        $userID = \Auth::user()->id;

        //get data from JS
        $taskDataFromJS = $request->all();

        //save new task into taskdata table
        return TaskData::create([
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

    public function getAllTasks(){
        if(\Auth::check()){
            $userID = \Auth::user()->id;
            $datas = TaskData::all()->where('user_id', $userID);
            return $datas;
        }
        else{
            return '';
        }
    }

    public function update(TaskData $taskData){

    }


}
