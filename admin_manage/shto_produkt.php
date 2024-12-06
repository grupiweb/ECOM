<?php
include('../includes/connect.php');

if(isset($_POST['shto_produkt'])){
    $produkt_name=$_POST['produkt_name'];
    $produkt_description=$_POST['produkt_description'];
    $produkt_keywords=$_POST['produkt_keywords'];
    $produkt_liga=$_POST['produkt_liga'];
    $produkt_ekip=$_POST['produkt_ekip'];
    $produkt_price=$_POST['produkt_price'];
    $produkt_status='true';
    $produkt_image1=$_FILES['produkt_image1']['name'];
    $produkt_image2=$_FILES['produkt_image2']['name'];
    $produkt_image3=$_FILES['produkt_image3']['name'];

    $temp_image1=$_FILES['produkt_image1']['tmp_name'];
    $temp_image2=$_FILES['produkt_image2']['tmp_name'];
    $temp_image3=$_FILES['produkt_image2']['tmp_name'];


    if($produkt_name=='' or $produkt_description=='' or $produkt_keywords=='' or $produkt_liga=='' or $produkt_ekip=='' or $produkt_price=='' or $produkt_image1=='' or $produkt_image2=='' or $produkt_image3==''){
        echo "<script>alert('Ju lutem jepni informacionin e plote.')</script>";
        exit();
    }else{
        move_uploaded_file($temp_image1,"./produkt_image/$produkt_image1");
        move_uploaded_file($temp_image2,"./produkt_image/$produkt_image2");
        move_uploaded_file($temp_image3,"./produkt_image/$produkt_image3");

    }

    $insert_products = "insert into `produkt` (produkt_name,produkt_description,produkt_keywords,liga_id,ekip_id,produkt_image1,produkt_image2,produkt_image3,produkt_price,date,status) values ('$produkt_name','$produkt_description','$produkt_keywords','$produkt_liga','$produkt_ekip','$produkt_image1','$produkt_image2','$produkt_image3','$produkt_price',NOW(),'$produkt_status')";
    $result_query=mysqli_query($con,$insert_products);
    if($result_query){
        echo "<script>alert('Produkti u shtua me sukses')</script>";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shto Produkte - Admin</title>
    <!-- bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
     <!-- font awesome link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <!-- css file -->
      <link rel="stylesheet" href="style.css">
 </head>
<body class="bg-light">
    <div class="container mt-3">
        <h1 class="text-center">Insert Products</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-outline mb-4 w-50 m-auto">
                <label class="form-label" for="produkt_name">Emri i Produktit</label>
                <input type="text" placeholder="Shkruaj emrin e produktit" required="required" autocomplete="off" class="form-control" name="produkt_name" id="produkt_name">
            </div>

            <div class="form-outline mb-4 w-50 m-auto">
                <label class="form-label" for="produkt_description">Pershkrimi i Produktit</label>
                <input type="text" placeholder="Shkruaj pershkrimin e produktit" required="required" autocomplete="off" class="form-control" name="produkt_description" id="produkt_description">
            </div>
            
            <div class="form-outline mb-4 w-50 m-auto">
                <label class="form-label" for="produkt_keywords">Keywords per Produktin</label>
                <input type="text" placeholder="Shkruaj keywords e produktit" required="required" autocomplete="off" class="form-control" name="produkt_keywords" id="produkt_keywords">
            </div>

            <div class="form-outline mb-4 w-50 m-auto">
                <select  class="form-select" name="produkt_liga" id="produkt_liga">
                    <option value="">Zgjidh nje lige</option>
                    
                    <?php
                        $select_query="Select * from `liga`";
                        $result_query=mysqli_query($con,$select_query);
                        while($row=mysqli_fetch_assoc($result_query)){
                            $liga_name=$row['liga_name'];
                            $liga_id=$row['liga_id'];
                            echo "<option value='$liga_id'>$liga_name</option>";
                        }
                    ?>
                    
                    
                </select>
            </div>

            <div class="form-outline mb-4 w-50 m-auto">
                <select  class="form-select" name="produkt_ekip" id="produkt_ekip">
                    <option value="">Zgjidh nje ekip</option>
                    <?php
                        $select_query="Select * from `ekip`";
                        $result_query=mysqli_query($con,$select_query);
                        while($row=mysqli_fetch_assoc($result_query)){
                            $ekip_name=$row['ekip_name'];
                            $ekip_id=$row['ekip_id'];
                            echo "<option value='$ekip_id'>$ekip_name</option>";
                        }
                    ?>
                    

                </select>
            </div>

            <div class="form-outline mb-4 w-50 m-auto"> 
                <label class="form-label" for="produkt_image1">Foto  e produktit 1</label>
                <input type="file"  required="required"  class="form-control" name="produkt_image1" id="produkt_image1">
            </div>
            <div class="form-outline mb-4 w-50 m-auto"> 
                <label class="form-label" for="produkt_image2">Foto  e produktit 2</label>
                <input type="file"  required="required"  class="form-control" name="produkt_image2" id="produkt_image2">
            </div>
            <div class="form-outline mb-4 w-50 m-auto"> 
                <label class="form-label" for="produkt_image3">Foto e produktit 3</label>
                <input type="file"  required="required"  class="form-control" name="produkt_image3" id="produkt_image3">
            </div>

            <div class="form-outline mb-4 w-50 m-auto">
                <label class="form-label" for="produkt_price">Cmimi i Produktit</label>
                <input type="text" placeholder="Shkruaj cmimin e produktit" required="required" autocomplete="off" class="form-control" name="produkt_price" id="produkt_price">
            </div>

            <div class="text-center form-outline mb-4 w-50 m-auto">
                <input type="submit" class="btn btn-info mb-3 px-2" name="shto_produkt" id="shkto_produkt" value="Shto produktin">
            </div>
        </form>
    </div>
    
</body>
</html>