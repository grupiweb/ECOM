<?php
// Start the session and connect to the database
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('includes/connect.php');
global $con;

// Check if the required data is provided
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = intval($_POST['product_id']); // Ensure it's an integer
    $quantity = intval($_POST['quantity']);     // Ensure it's an integer

    // Ensure the user is logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = intval($_SESSION['user_id']); // Sanitize user ID

        // Update the quantity in the cart
        $update_query = "UPDATE `cart` SET quantity = '$quantity' WHERE user_id = '$user_id' AND produkt_id = '$product_id'";
        $update_result = mysqli_query($con, $update_query);

        if ($update_result) {
            // Fetch the product price
            $product_query = "SELECT produkt_price FROM `produkt` WHERE produkt_id = '$product_id'";
            $product_result = mysqli_query($con, $product_query);

            if ($product_result && mysqli_num_rows($product_result) > 0) {
                $product_row = mysqli_fetch_assoc($product_result);
                $product_price = $product_row['produkt_price'];

                // Calculate the new total price for the product
                $new_total_price = $product_price * $quantity;

                // Return the updated price (plain text)
                echo $new_total_price;
            } else {
                // If the product is not found, return an error
                echo 'error';
            }
        } else {
            // If the update query fails, return an error
            echo 'error';
        }
    } else {
        // If the user is not logged in, return an error
        echo 'error';
    }
} else {
    // If required data is missing, return an error
    echo 'error';
}
?>
