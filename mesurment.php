<?php include 'conn.php'; ?>
<?php include 'header.php'; ?>
   
<style>
    form{
        width: 550px;
        height:800px;
        margin-top:50px ;
        padding: 25px;
        border: 2px solid gray;
    }
    .pt{
      margin-top: 10px;
    }
    .col-sm-10{
        width: 500px;
    }
    .form-control{
        width: 500px;
        margin-right: 0px;
    }
    .btn{
      width: 100px;
      margin-left: 100px;
    }
</style>
<center>
<form method="post">
    <h3 class="sh">SHIRT</h3>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Shulder</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="inputEmail3" placeholder="">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label">Chest</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="inputPassword3" placeholder="">
    </div>
    <div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label">Arm</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="inputPassword3" placeholder="">
    </div>
    
    <h3 class="pt">PANT</h3>
    <div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label">Hip</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="inputPassword3" placeholder="">
    </div>

    <div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label">Waist</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="inputPassword3" placeholder="">
    </div>

    <div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label">Bottom</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="inputPassword3" placeholder="">
    </div>
  </div>

  <div class="form-group row">
    <div class="col-sm-2">confirm</div>
    <div class="col-sm-10">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="gridCheck1">
        <label class="form-check-label" for="gridCheck1">
        </label>
      </div>
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-10">
      <button type="submit" class="btn btn-secondary">Submit</button>
    </div>
  </div>
</form>


</center>
<?php include 'footer.php'; ?>