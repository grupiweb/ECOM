<?php
include('../includes/connect.php');
session_start();

// Ensure user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'You must log in to add products to your cart.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produkt_id'])) {
    $user_id = $_SESSION['id'];
    $produkt_id = intval($_POST['produkt_id']);
    $sasia = intval($_POST['sasia']);

    // Check if product already exists in the cart
    $check_query = "SELECT * FROM `cart` WHERE `user_id` = '$user_id' AND `produkt_id` = '$produkt_id'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Update quantity if product exists
        $update_query = "UPDATE `cart` SET `sasia` = `sasia` + $sasia WHERE `user_id` = '$user_id' AND `produkt_id` = '$produkt_id'";
        mysqli_query($con, $update_query);
        echo json_encode(['status' => 'success', 'message' => 'Product quantity updated in cart.']);
    } else {
        // Insert new product into cart
        $insert_query = "INSERT INTO `cart` (`user_id`, `produkt_id`, `sasia`, `added_on`) VALUES ('$user_id', '$produkt_id', '$sasia', NOW())";
        mysqli_query($con, $insert_query);
        echo json_encode(['status' => 'success', 'message' => 'Product added to cart.']);
    }
}
?>
