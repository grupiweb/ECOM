<?php
include('../includes/connect.php');
if(isset($_POST['shto_liga'])){
    $liga_name = $_POST['liga_name'];
    
    $select_query = "Select * from `liga` where liga_name='$liga_name'";
    $result_select = mysqli_query($con,$select_query);
    $number = mysqli_num_rows($result_select);
    if($number>0){
      echo "<script>alert('Liga ekziston aktualisht');</script>";
    }else{
    $insert_query="insert into `liga` (liga_name) values ('$liga_name')";
    $result = mysqli_query($con,$insert_query);
    if($result){
      echo "<script>alert('Liga u shtua me sukses');</script>";
    }
  }
  }
?>
<h2 class="text-center">Shto liga</h2>
<form action="" method="post" class="mb-2">
<div class="input-group mb-2 w-90">
  <span class="input-group-text bg-info" id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
  <input type="text" class="form-control" name="liga_name" placeholder="Shto nje lige" aria-label="Shto nje lige" aria-describedby="basic-addon1">
</div>
<div class=" input-group d-flex justify-content-center align-items-center input-group mb-2 w-10 m-auto">
  
  <input type="submit" class="bg-info  d-flex justify-center align-items-center p-2 my-3 border-0" name="shto_liga" value="Shto nje lige">
</div>
</form>