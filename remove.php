<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

// Check if the product ID is set
if (isset($_GET['produkt_id'])) {
    include("includes/connect.php"); // Include database connection

    $produkt_id = $_GET['produkt_id'];
    $user_id = $_SESSION['id'];

    // Remove the item from the cart
    $delete_query = "DELETE FROM `cart` WHERE user_id = '$user_id' AND produkt_id = '$produkt_id'";
    $delete_result = mysqli_query($con, $delete_query);

    if ($delete_result) {
        // Redirect to the cart page after successful removal
        header("Location: cart.php");
        exit;
    } else {
        // Handle error (optional)
        header("Location: cart.php?error=1"); // Redirect with an error flag
        exit;
    }
} else {
    // Redirect to the cart page if no product ID is provided
    header("Location: cart.php");
    exit;
}
?>
