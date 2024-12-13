<?php
error_reporting(0);
session_start();
require_once "connect.php";



$query_user_data = "SELECT user_id,
                           username,
                           email
                    FROM users
                    WHERE user_id = '".mysqli_real_escape_string($conn, $_SESSION['user_id'])."'";


$result_user_data = mysqli_query($conn, $query_user_data);
if (!$result_user_data){
    //TODO: Show an error, do not break the page
    echo "Error";
    exit;
}

$data = array();
while ($row = mysqli_fetch_assoc($result_user_data)){
    $data['user_id'] = $row['user_id'];
    $data['username'] = $row['username'];
    $data['email'] = $row['email'];
}

require_once "includes/auth/footer.php";

?>

