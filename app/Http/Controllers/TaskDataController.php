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
            'timeWorked' => (int)$taskDataFromJS['timeWorked'],
            'workDoneMessage' => $taskDataFromJS['workDoneMessage'],
            'toggleMode' => json_decode($taskDataFromJS['toggleMode']),
            'workTimeUpdateCheck' => (int)$taskDataFromJS['workTimeUpdateCheck'],
            'playAndPauseButtonSymbole' => $taskDataFromJS['playAndPauseButtonSymbole'],
            'taskCompleted' => json_decode($taskDataFromJS['taskCompleted']),
            'color' => $taskDataFromJS['color'],
            'todaysTask' =>json_decode($taskDataFromJS['todaysTask']),

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

    public function updateTaskData(Request $request){
        $taskDataFromJS = $request->all();
        $updateDetails = array(
            'task' => $taskDataFromJS['task'],
            'description' => $taskDataFromJS['description'],
            'timeWorked' => (int)$taskDataFromJS['timeWorked'],
            'workDoneMessage' => $taskDataFromJS['workDoneMessage'],
            'toggleMode' => false,
            'workTimeUpdateCheck' => (int)$taskDataFromJS['workTimeUpdateCheck'],
            'playAndPauseButtonSymbole' => '<i class="material-icons" md-148>play_circle_outline</i>',
            'taskCompleted' => json_decode($taskDataFromJS['taskCompleted']),
            'color' => $taskDataFromJS['color'],
            'todaysTask' => json_decode($taskDataFromJS['todaysTask'])
        );

        TaskData::where('id', $taskDataFromJS['id'])->update($updateDetails);

        $task= TaskData::all()->where('id', $taskDataFromJS['id']);
        return 'task has been successfully updated';

    }

    public function removeTaskFromToday(Request $request){
        $taskDataFromJS = $request->all();
        $updateDetails = array('todaysTask' => false);

        TaskData::where('id', (int)$taskDataFromJS['id'])->update($updateDetails);
        
        return 'task Removed from today';
    }

    public function deleteTask(Request $request){
        $taskDataFromJS = $request->all();

        $task = TaskData::where('id', $taskDataFromJS['id']);
        $task->delete();

        return 'task Deleted';
    }

}
