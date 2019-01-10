<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskData extends Model
{
    protected $fillable = [
        'user_id', 'task', 'description', 'timeWorked', 'workDoneMessage', 'toggleMode', 'workTimeUpdateCheck','playAndPauseButtonSymbole', 'taskCompleted', 'color', 'todaysTask',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
        // so to get the user of the task u can do $users = App\TaskData::find(1); then $users will have the user of the task u wn find
    }

}
