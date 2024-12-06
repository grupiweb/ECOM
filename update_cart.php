<?php
// Start the session and connect to the database
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('includes/connect.php');
global $con;

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Ensure user is logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Update the quantity in the cart
        $update_query = "UPDATE `cart` SET quantity = '$quantity' WHERE user_id = '$user_id' AND produkt_id = '$product_id'";
        $update_result = mysqli_query($con, $update_query);

        if ($update_result) {
            // Fetch updated product price
            $product_query = "SELECT produkt_price FROM `produkt` WHERE produkt_id = '$product_id'";
            $product_result = mysqli_query($con, $product_query);
            $product_row = mysqli_fetch_assoc($product_result);
            $product_price = $product_row['produkt_price'];

            // Calculate the new total price
            $new_total_price = $product_price * $quantity;

            // Return the updated price (plain text, no JSON)
            echo $new_total_price;
        } else {
            echo 'error';
        }
    } else {
        echo 'error';
    }
}
?>
