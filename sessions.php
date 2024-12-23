<?php

session_start();
if(isset($_SESSION['user_id'])){
    echo "User ID: " . $_SESSION['user_id'];
}else {
    // If the session variable is not set, print a message
    echo "No user is logged in.";
}
?>