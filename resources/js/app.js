
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

    methods: {
        openTaskAdder: function(){
            this.$modal.show('add-task')
        },

        updateTaskList (value) {
            this.Tasks.push(JSON.parse(JSON.stringify(value)));
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
              this.Tasks[index].playAndPauseButttonSymbole = '<i class="material-icons" md-148>play_circle_outline</i>';
            else if(this.Tasks[index].toggleMode)
                this.Tasks[index].playAndPauseButttonSymbole = '<i class="material-icons" md-148>pause_circle_outline</i>';
            
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
        },

        deleteCurrentTask: function(index){
            // before deleting save totalworkTime of this task
            this.totalWorkTimeOfDeletedTasks = this.totalWorkTimeOfDeletedTasks + this.Tasks[index].timeWorked;
            this.Tasks.splice(index,1);
        },

        taskCompleted: function(index){
            this.Tasks[index].taskCompleted = !this.Tasks[index].taskCompleted;
            if(this.Tasks[index].taskCompleted)
              this.Tasks[index].color = '#d9ffcc';
            else
              this.Tasks[index].color = 'white';
          }

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



    },
});



