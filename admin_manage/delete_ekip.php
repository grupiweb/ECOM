<?php
if (isset($_GET['delete_ekip'])) {
    $delete_ekip = $_GET['delete_ekip'];
    

    $delete_query = "DELETE FROM `ekip` WHERE ekip_id = $delete_ekip";
    $result = mysqli_query($con, $delete_query);
    
    if ($result) {
        echo "<script>alert('Ekipi u fshi');</script>";
        echo "<script>window.open('./index.php?shiko_ekip', '_self');</script>";
    }
}
?>
