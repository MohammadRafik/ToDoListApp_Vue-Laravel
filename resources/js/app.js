
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// including a vue extension/component for custimaizable pop-ups
import VModal from 'vue-js-modal'
Vue.use(VModal)


// including axios                  for some reason this is causing a bug
                                    // import axios from 'axios'
                                    // Vue.use(axios)
Vue.prototype.$axios = axios;


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('add-a-task', require('./components/addTask.vue').default);
Vue.component('stopwatch', require('./components/stopwatch.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */






const app = new Vue({
    el: '#app',
    data() {
        return {
            Tasks: [],
            totalWorkTimeOfDeletedTasks: 0,
        }
    },
        //first we check to see if there are any tasks on the server, if yes we load it into this.Tasks
    mounted: function() {
        let self= this;
            //load tasks from the server
            console.log('making a axios get request');
             axios.get('/getAllTasks')
            .then(function (response) {
                //check if response.data is an array
                console.log('axios get request successful');
                if(Object.prototype.toString.call(response.data) == '[object Array]'){
                response.data.forEach(function(element){
                    var taskFromServer = {
                        id: element.id,
                        User_id: element.user_id,
                        task: element.task,
                        description: element.description,
                        timeWorked: element.timeWorked,
                        workDoneMessage: element.workDoneMessage,
                        toggleMode: element.toggleMode,
                        workTimeUpdateCheck: element.workTimeUpdateCheck,
                        playAndPauseButtonSymbole: element.playAndPauseButtonSymbole,
                        taskCompleted: element.taskCompleted,
                        color: element.color,
                        todaysTask: element.todaysTask,
                    }
                    self.Tasks.push(taskFromServer);
                });
                }
                //check if response.data is an object
                else if(typeof response.data == 'object'){
                        for(var property in response.data){
                            var taskFromServer = {
                                id: response.data[property].id,
                                User_id: response.data[property].user_id,
                                task: response.data[property].task,
                                description: response.data[property].description,
                                timeWorked: response.data[property].timeWorked,
                                workDoneMessage: response.data[property].workDoneMessage,
                                toggleMode: response.data[property].toggleMode,
                                workTimeUpdateCheck: response.data[property].workTimeUpdateCheck,
                                playAndPauseButtonSymbole: response.data[property].playAndPauseButtonSymbole,
                                taskCompleted: response.data[property].taskCompleted,
                                color: response.data[property].color,
                                todaysTask: response.data[property].todaysTask,
                            }
                            self.Tasks.push(taskFromServer);
                        }
                }
            })
            .catch(function (error) {
            console.log(error.response);
            });
    },

    methods: {
        openTaskAdder: function()
        {
            this.$modal.show('add-task')
        },

        updateTaskList (value)
        {
            var valueReal = JSON.parse(JSON.stringify(value));
            this.Tasks.push(valueReal);
        },


        toggleTrigger: function(index){
            //   switch toggle mode
              this.Tasks[index].toggleMode = !this.Tasks[index].toggleMode;

            //   here we update work done message if new work has started on a new task
              if(this.Tasks[index].workDoneMessage == 'You havent started working on this task yet'){
                this.Tasks[index].workDoneMessage = "less than a minute";
              }

            //   resetting a variable to 0 everytime user ends a session of a task
              if(!this.Tasks[index].toggleMode){
                  this.Tasks[index].workTimeUpdateCheck = 0;
              }

            //   here we update what the picture on the button should be
            if(!this.Tasks[index].toggleMode)
              this.Tasks[index].playAndPauseButtonSymbole = '<i class="material-icons" md-148>play_circle_outline</i>';
            else if(this.Tasks[index].toggleMode)
                this.Tasks[index].playAndPauseButtonSymbole = '<i class="material-icons" md-148>pause_circle_outline</i>';
            
            this.updateTaskOnServer(index);
        },



        updateTotalWorkTime: function(value, index){
            this.Tasks[index].timeWorked = this.Tasks[index].timeWorked + value - this.Tasks[index].workTimeUpdateCheck;
            this.Tasks[index].workTimeUpdateCheck = value;

            var i;
            var mins;
            var hours;
            for (i = 0; this.Tasks.length>i ; i++){
                mins = this.Tasks[i].timeWorked % 60;
                hours = parseInt(this.Tasks[i].timeWorked / 60);
                if(hours)
                    this.Tasks[i].workDoneMessage =  " " + hours + " Hours and " + mins + " minutes";
                else if(mins)
                    this.Tasks[i].workDoneMessage =  " " + mins + " Minutes";
            }
            this.updateTaskOnServer(index);
        },

        deleteCurrentTask: function(index){
            // before deleting save totalworkTime of this task
            this.totalWorkTimeOfDeletedTasks = this.totalWorkTimeOfDeletedTasks + this.Tasks[index].timeWorked;
            this.deleteTaskOnBackEnd(index);
            this.Tasks.splice(index,1);
            
        },

        taskCompleted: function(index){
            this.Tasks[index].taskCompleted = !this.Tasks[index].taskCompleted;
            if(this.Tasks[index].taskCompleted)
              this.Tasks[index].color = '#d9ffcc';
            else
              this.Tasks[index].color = 'white';
              this.updateTaskOnServer(index);
          },

          updateTaskOnServer(index){
              console.log('making an axios post request to update backend');
              //change json to formdata
              var form_data = new FormData();
              var item;
              item = this.Tasks[index];
                for ( var key in item ) {
                    form_data.append(key, item[key]);
                }
            axios.post('/updateTaskData', form_data)
            .then(function(response){
                console.log('axios post request successful');
            })
            .catch(function(error){
                console.log(error.response);
            });
          },

          deleteTaskOnBackEnd(index){
              console.log('making an axios post request to delete task on backend');
                //change json to formdata
              var form_data = new FormData();
              var item;
              item = this.Tasks[index];
                for ( var key in item ) {
                    form_data.append(key, item[key]);
                }
            axios.post('/deleteCurrentTask', form_data)
            .then(function(response){
                //do something if it passes here
                console.log('axios post request successful');
            })
            .catch(function(error){
                console.log(error.response);
            });
          },

          removeTaskFromToday(index){

          },

          resetToNewDay(){

          },
    },

    computed:{
        totalWorkOfAllTasks: function(){
            var i;
            var totalWorkTime = 0;
            for(i=0;this.Tasks.length > i; i++){
                totalWorkTime = this.Tasks[i].timeWorked + totalWorkTime;
            }
            totalWorkTime = totalWorkTime + this.totalWorkTimeOfDeletedTasks
            var mins;
            var hours;
            mins = totalWorkTime % 60;
            hours = parseInt(totalWorkTime/60);
            if(hours)
                return  " " + hours + " Hours and " + mins + " minutes";
            else if(mins)
                return  " " + mins + " Minutes";
        },

        numberOfTasks: function(){
            return this.Tasks.length;
        },



    },
});



