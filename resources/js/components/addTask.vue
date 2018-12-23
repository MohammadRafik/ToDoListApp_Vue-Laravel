<template>
<modal name="add-task" transition="pop-out" :height="400">
  <div class="box">
    <form>
      <h3>Add a Task</h3>
      <input v-model='Task.task' class="inputStyle" type="text" placeholder="task Title"><br>
      <textarea v-model='Task.description' name="taskDescription" id="" cols="30" rows="10"></textarea>
      <br>
      <button v-on:click.prevent='savenewtask'>Save</button>
    </form>
  </div>
</modal>
</template>
<script>

export default {
  name: 'addTask',
  data () {
    return {
      Task:{
        task: '',
        description: '',
        timeWorked: 0,
        workDoneMessage: 'You havent started working on this task yet',
        toggleMode: false,
        workTimeUpdateCheck: ''
      }


    }
  },
  created () {

  },
  computed: {
    
  },

  methods:{
    savenewtask: function(){
      this.$emit('savenewtask', this.Task)
    }
  }


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
  justify-content: center;
  padding:20px;

}

.inputStyle {
  position: center;
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}
</style>