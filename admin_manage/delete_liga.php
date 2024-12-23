<?php
if (isset($_GET['delete_liga'])) {
    $delete_liga = $_GET['delete_liga'];
    

    $delete_query = "DELETE FROM `liga` WHERE liga_id = $delete_liga";
    $result = mysqli_query($con, $delete_query);
    
    if ($result) {
        echo "<script>alert('Liga u fshi me sukses');</script>";
        echo "<script>window.open('./index.php?shiko_liga', '_self');</script>";
    }
}
?>
