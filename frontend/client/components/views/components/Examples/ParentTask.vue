<template>

  <div class="row" >
    <div class="col-sm-1 parent-handle">
      <button class="btn btn-link "><i class="fa fa-arrows-alt"></i></button>
    </div>
    <div class="col-sm-3 " >
      <div class="input-group">
        <input type="text" v-model="citems.parent" class="form-control parent-task" name="parent_task"
               placeholder="Parent Task"  />
      </div>
    </div>
    <div class="col-sm-2 ">
      <!--<datepicker v-model="dateStartValue" :clear-button="clear" @input="dateStartValueSelected"-->
      <!--:icons-font="font" :format="format"    :placeholder="dateStartPlaceholder"></datepicker>-->
    </div>
    <div class="col-sm-2 ">
      <!--<datepicker v-model="dateEndValue" :clear-button="clear" :format="format" :icons-font="font"  :placeholder="dateEndPlaceholder" @input="dateEndValueSelected"></datepicker>-->
    </div>
    <div class="col-sm-2 ">
      <div class="input-group">
        <select class="form-control" >
          <option value="">Select Milestone</option>
          <option value="Milestone 1">Milestone 1</option>
          <option value="Milestone 2">Milestone 2</option>
          <option value="Milestone 3">Milestone 3</option>
          <option value="Milestone 4">Milestone 3</option>
          <option value="Milestone 5">Milestone 3</option>
        </select>
      </div>

    </div>
    <div class="col-sm-2 ">
      <button class="btn btn-link"><i class="fa fa-pencil"></i> Notes</button>
    </div>

  </div>

</template>

<script>
  export default{
    name: 'parent-task'
  }
</script>
