<?php
include('../includes/connect.php');
if(isset($_POST['shto_ekip'])){
    $ekip_name = $_POST['ekip_name'];
    
    $select_query = "Select * from `ekip` where ekip_name='$ekip_name'";
    $result_select = mysqli_query($con,$select_query);
    $number = mysqli_num_rows($result_select);
    if($number>0){
      echo "<script>alert('Ekipi ekziston aktualisht');</script>";
    }else{
    $insert_query="insert into `ekip` (ekip_name) values ('$ekip_name')";
    $result = mysqli_query($con,$insert_query);
    if($result){
      echo "<script>alert('Ekipi u shtua me sukses');</script>";
    }
  }
  }
?>
<h2 class="text-center">Shto ekipe</h2>
<form action="" method="post" class="mb-2">
<div class="input-group mb-2 w-90">
  <span class="input-group-text bg-info" id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
  <input type="text" class="form-control" name="ekip_name" placeholder="Shto nje ekip" aria-label="ekip" aria-describedby="basic-addon1">
</div>
<div class="d-flex justify-content-center align-items-center input-group mb-2 w-10 m-auto">
  <input type="submit" class="bg-info  d-flex justify-center align-items-center p-2 my-3 border-0" name="shto_ekip"  value="Shto nje ekip"> 
  
</div>
</form>