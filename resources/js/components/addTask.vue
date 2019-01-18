<template>
<modal name="add-task" transition="pop-out" :height="400">
  <div class="box">

    <!-- <div slot="top-right">
      <button @click="$modal.hide('add-task')">
        ❌
      </button>
    </div> -->

  <div class="form-group">
    <form>
      <div class='boxTitle'>
        <h3>Add a Task</h3>
      </div>
      <div class='inputFields'>
          <input type='text' v-model='Task.task' class="form-control" placeholder="Task Title" id='modalTaskTitle' ><br>
          <textarea type='text' v-model='Task.description' name="taskDescription" class="form-control" cols="30" rows="5" placeholder="Description (Optional)"></textarea>
      </div>
      <br>
      <div class="col-lg-3 center-block">
        <button v-on:click.prevent='savenewtask' v-on:click="$modal.hide('add-task')" class="btn btn-primary">Create</button>
      </div>
    </form>
  </div>
  </div>
</modal>
</template>
<script>

export default {
  name: 'addTask',
  data () {
    return {
      Task:{
        id: '',
        User_id: '',
        task: '',
        description: '',
        timeWorked: 0,
        workDoneMessage: 'You havent started working on this task yet',
        toggleMode: false,
        workTimeUpdateCheck: '',
        playAndPauseButtonSymbole: '<i class="material-icons" md-148>play_circle_outline</i>',
        taskCompleted: false,
        color: 'white',
        todaysTask: true,

      }


    }
  },
  // this triggeres when something in Task changes... i think
  // watch: {
  //       Task: {
  //         handler: function(newValue){
  //           console.log('something changed')
  //           console.log(newValue)
  //         },
  //         deep:true
  //   }
  // },

  methods:{
    savenewtask: function(){
      //create the task on the server then emit it to parent vue instance in app.js
      var them=this;
                //change json to formdata
              var form_data = new FormData();
              var item;
              item = them.Task;
                for ( var key in item ) {
                    form_data.append(key, item[key]);
                }

        axios.post('/createNewTask', them.Task)
        .then(function (response) {
            them.$emit('savenewtask', response.data);
            them.Task.task = '';
            them.Task.description = '';  
            console.log('created task on backend');
          })
          .catch(function (error) {
            console.log(error);
          });

    },

  },




}
</script>
<style lang="scss">
$background_color: #404142;

.box {
  background: white;
  overflow: hidden;
  width: 656px;
  height: 400px;
  border-radius: 2px;
  box-sizing: border-box;
  box-shadow: 0 0 40px black;
  color: #8b8c8d;
  display:flex;

  padding:20px;

}

.boxTitle{
  width: 565px;
  height:55px;
  display:flex;
  justify-content:center;
  padding:20px;
  margin-bottom:20px;
}

.inputFields {
  display:flex;
  justify-content:flex-start;
  flex-direction:column;
  width: 565px;

}

.inputTitle{
  width:80%;
}


</style>