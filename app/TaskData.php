<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskData extends Model
{
    

    public function user()
    {
        return $this->belongsTo('App\User');
        // so to get the user of the task u can do $users = App\TaskData::find(1); then $users will have the user of the task u wn find
    }

}
