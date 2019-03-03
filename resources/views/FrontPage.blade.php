@extends('layouts.app')

@section('content')

@guest
    {{-- guest user --}}
    <div id="appNotLoggedIn" v-cloak>
        <div class="container">
            <div class="row justify-content-center">
            <div class="col-sm-10">
            <div class="card">
                <div class="card-header">Todays Tasks</div>    
                    {{-- show all tasks --}}
                    <ul class="list-group list-group-flush">
    
                        <li class='list-group-item' v-if='!numberOfTasks'> Looks like you dont have any tasks to work on, click the blue button below to create one! </li>
    
                        <transition-group name='fadeSlow'>
                        <li class="list-group-item" v-for='(task, index) in Tasks' :key='task.id' v-bind:style="{ backgroundColor: task.color}">
                        <div class='taskVerticalControl' >
                            <div class='taskHeader'>
                                <h3 class=taskTitle title='Task Title'> @{{ task.task }}</h3> 
                                <button class='taskTimeToggle' v-on:click='toggleTrigger(index)' title='start/stop session' v-html='task.playAndPauseButtonSymbole' ></button>
                                <transition name='fade'>
                                    <p v-if="Tasks[index].toggleMode" class='taskSessionTimer' title='time of current session'>
                                        <vue-title></vue-title>
                                        current Session: <stopwatch v-on:afteronemin='updateTotalWorkTime($event, index)'></stopwatch>
                                    </p>
                                </transition>
                                <a href='#' class='closeTask' v-on:click.prevent='deleteCurrentTask(index)' title='delete this task'></a>
                            </div>
                            <div class='taskBody'>
                                <p class='taskDescription' title='Task Description'> @{{task.description}}</p>
                                <div class='completeTaskButton'>
                                    <button class="btn btn-finishTask" v-on:click='taskCompleted(index)'>Task completed</button>
                                </div>
                            </div>
                            <div class='taskFooter'>
                                <p title='Total work done on this task'>total work: @{{ task.workDoneMessage }}</p>
                            </div>
                        </div>
                        </li>
                        </transition-group>
                        </div>
                    </div>
                    </div>
                    </ul>
                    {{-- add new task --}}
                    <div class="row justify-content-center">
                    <div class="col-sm-10">
                    <div class="card-body">
                        <add-a-task-nli v-on:savenewtask='updateTaskList'></add-a-task-nli>
                        <div class='addTaskButton'>
                            <button v-on:click="openTaskAdder" class="btn btn-primary">add  a task +</button>
                        </div>
                        <p v-if="totalWorkOfAllTasks" title='total work done on all tasks'>Total work done today: @{{ totalWorkOfAllTasks }}</p>
                    </div>
                    <p class='beforeFooter' v-if='numberOfTasks'>Please note that If you're logged in you wont have to worry about losing your data evertime you close this page</p>
                    </div>
                    </div>
                </div>
    </div>
@else 
    {{-- this section is for logged in users --}}
<div id='app' v-cloak>
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-sm-10">
        <div class="card">
            <div class="card-header">Todays Tasks</div>
                  
                {{-- show all tasks --}}
                <ul class="list-group list-group-flush">

                    <li class='list-group-item' v-if='!numberOfTasks'> Looks like you dont have any tasks to work on, click the blue button below to create one! </li>

                    <transition-group name='fadeSlow'>
                    <li class="list-group-item" v-for='(task, index) in Tasks' :key='task.id' v-bind:style="{ backgroundColor: task.color}">
                    <div class='taskVerticalControl' >
                        <div class='taskHeader'>
                            <h3 class=taskTitle title='Task Title'> @{{ task.task }}</h3> 
                            <button class='taskTimeToggle' v-on:click='toggleTrigger(index)' title='start/stop session' v-html='task.playAndPauseButtonSymbole' ></button>
                            <transition name='fade'>
                                <p v-if="Tasks[index].toggleMode" class='taskSessionTimer' title='time of current session'>
                                    <vue-title></vue-title>
                                    current Session: <stopwatch v-on:afteronemin='updateTotalWorkTime($event, index)'></stopwatch> 
                                </p>
                            </transition>
                            <a href='#' class='closeTask' v-on:click.prevent='deleteCurrentTask(index)' title='delete this task'></a>
                        </div>
                        <div class='taskBody'>
                            <p class='taskDescription' title='Task Description'> @{{task.description}}</p>
                            <div class='completeTaskButton'>
                                <button class="btn btn-finishTask" v-on:click='taskCompleted(index)'>Task completed</button>
                            </div>
                        </div>
                        <div class='taskFooter'>
                            <p title='Total work done on this task'>total work: @{{ task.workDoneMessage }}</p>
                        </div>
                    </div>
                    </li>
                    </transition-group>
                    </div>
                </div>
                </div>
                </ul>
                {{-- add new task --}}
                <div class="row justify-content-center">
                <div class="col-sm-10">
                <div class="card-body">
                    <add-a-task v-on:savenewtask='updateTaskList'></add-a-task>
                    <div class='addTaskButton'>
                        <button v-on:click="openTaskAdder" class="btn btn-primary">add  a task +</button>
                    </div>
                    <p v-if="totalWorkOfAllTasks" title='total work done on all tasks'>Total work done today: @{{ totalWorkOfAllTasks }}</p>
                </div>
                </div>
                </div>
            </div>
    </div>
@endguest
@endsection

@section('style')





<style>

[v-cloak] { display: none; }

    .taskVerticalControl{
    }

    .taskCompletedText{
        text-decoration: line-through;
    }

    .taskCompletedColor{
        background-color:#ecffe6;
    }


    .taskHeader{
        display:grid;
        grid-template-columns:2% 40% 10% 5% 5% 20% 15% 3%;
        padding:1px;
    }

    .taskTitle{
        grid-column-start:2;
    }

    .taskTimeToggle{
        grid-column-start:4;
        background: none;
        border: none;
        padding: 10px 0px;
        font: inherit;
        cursor: pointer;
        outline: inherit;
        border-radius:50%;
        opacity:0.6;

    }
    .taskTimeToggle:hover{
        opacity:1;
    }
    .taskTimeToggle:focus{
        outline:0;
    }

    .taskSessionTimer{
        grid-column-start:6;
        display:flex;
        align-items:flex-end;
    }

    /* close button style */
    .closeTask {
        position: absolute;
        right: 6px;
        top: 2px;
        width: 32px;
        height: 32px;
        opacity: 0.3;
        grid-column-start:8;
}
    .closeTask:hover {
     opacity: 1;
}
    .closeTask:before, .closeTask:after {
        position: absolute;
        left: 15px;
        content: ' ';
        height: 33px;
        width: 2px;
        background-color: #333;
}
    .closeTask:before {
        transform: rotate(45deg);
}
    .closeTask:after {
        transform: rotate(-45deg);
}
/* end of close button style */

    .taskBody{
        display:grid;
        grid-template-columns:5% 54% 43%;

        padding 1px;
    }

    .taskDescription{
        grid-column-start:2;
    }

    .btn-finishTask{
        grid-coloumn-start:3;
        background-color:lime;
        color:#fff;
    }

    .btn-finishTask:hover{
        background-color:limegreen;
    }

    .taskFooter{

    }

    .addTaskButton{

    }

    .beforeFooter{
        text-align:right;
    }

    /* transitoin effects */
.fade-enter-active, .fade-leave-active {
  transition: opacity .3s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}

/* ------------------------------------------ */
.fadeSlow-enter-active {
  transition: opacity 1s;
}

.fadeSlow-leave-active{
    transition: opacity 0s;
}

.fadeSlow-enter, .fadeSlow-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}



</style>
@endsection