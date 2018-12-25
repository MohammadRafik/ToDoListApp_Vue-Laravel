@extends('layouts.app')

@section('content')

@guest
    {{-- guest user --}}
    <div id="app">
            <br>
            <h1>Welcome to {{ config('app.name', 'ToDoList') }}!</h1><br>
            <h4><a href={{ route('register') }}> Register </a> to start using ToDoList</h4>
            <h5>already have an account? <a href= {{ route('login') }}>Login</a>
            
    </div>
@else 
    {{-- this section is for logged in users --}}
<div id='app'>
    <div class="container">
        <div class="card">
            <div class="card-header">Todays Tasks</div>      
                {{-- show all tasks --}}
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" v-for='(task, index) in Tasks' :key='index'>
                    <div class='taskVerticalControl'>
                        <div class='taskHeader'>
                            <h3 class=taskTitle title='Task Title'> @{{ task.task }}</h3> 
                            <button class='taskTimeToggle' v-on:click='toggleTrigger(index)' title='start/stop session' v-html='task.playAndPauseButttonSymbole' > </button>
                            <p v-if="Tasks[index].toggleMode" class='taskSessionTimer' title='time of current session'>current Session: <stopwatch v-on:afteronemin='updateTotalWorkTime($event, index)'></stopwatch> </p>
                            <a href='#' class='closeTask' v-on:click.prevent='deleteCurrentTask(index)' title='delete this task'></a>
                        </div>
                        <div class='taskBody'>
                            <p></p>
                            <p class='taskDescription' title='Task Description'> @{{task.description}}</p>
                        </div>
                        <div class='taskFooter'>
                            <p title='Total work done on this task'>total work: @{{ task.workDoneMessage }}</p>
                        </div>
                    </li>
                    </div>
                </ul>
                {{-- add new task --}}
                <div class="card-body">
                    <add-a-task v-on:savenewtask='updateTaskList'></add-a-task>
                    <button v-on:click="openTaskAdder">add  a task +</button>
                    <p v-if="totalWorkOfAllTasks" title='total work done on all tasks'>Total work done today: @{{ totalWorkOfAllTasks }}</p>
                </div>
            </div>
    </div>
</div>
@endguest
@endsection

@section('style')
<style>


    .taskVerticalControl{
    }

    .taskHeader{
        display:grid;
        grid-template-columns:2% 40% 20% 5% 5% 20% 5% 3%;
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

    }
    .taskTimeToggle:focus{
        outline:0;
    }

    .taskSessionTimer{
        grid-column-start:6;
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
        grid-template-columns:5% 46% 51%;

        padding 1px;
    }

    .taskDescription{
        grid-column-start:2;
    }

    .taskFooter{

    }

</style>
@endsection