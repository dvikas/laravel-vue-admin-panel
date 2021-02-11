<template>
  <div class="row sub-task-row">
  <div class="col-sm-1">
    <button class="btn btn-link"><i class="fa fa-arrows-alt"></i></button>
  </div>
  <div class="col-sm-10">
    <div  >
      <form >
        <div class="row">

          <div class="col-sm-4">
            <div class="form-group">
              <input type="text" class="form-control"
                     placeholder="Subtask"  />
            </div>
          </div>

          <div class="col-sm-2 ">
            <div class="form-group" >
              <input type="text" class="form-control"
                     placeholder="Quantity"  />
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group" >
              <input type="text" class="form-control"
                     placeholder="Unit"  />
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group" >
              <input type="text" class="form-control"
                     placeholder="Rate"  />
            </div>
          </div>
          <div class="col-sm-2" >
            <div class="form-group">
              <input type="text" class="form-control" name="total"
                     placeholder="Total" >
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label ><input type="checkbox"> Is Certificate required</label>
            </div>
          </div>
        </div>

      </form>
    </div>
  </div>
  <div class="col-sm-1">
    <button title="Delete subtask" class="btn btn-link" type="button">
      <i class="fa fa-trash-o text-maroon"></i></button>
  </div>


</div>

</template>

<script>
  export default{
  }
</script>
