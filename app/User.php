<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function TaskDatas()
    {
        return $this->hasMany('App\TaskData');
        // in the controller to get all tasks do: $tasks = App\User::find(1)->Task; then u have a bunch of Tasks in in $tasks and u can loop throguh it with a foreach of whatever
    }
}
