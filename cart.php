<?php
include('includes/connect.php');
include('functions/common_function.php');

session_start();

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
// Check if user is logged in
if (isset($_SESSION['id']) && $_SESSION['verified']!='1') {
  header("Location: verify.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-Commerce Website - Cart</title>
  <!-- bootstrap CSS link -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- font awesome link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- css file -->
  <link rel="stylesheet" href="style.css">
</head>

<body class="d-flex flex-column min-vh-100">
  <!-- navbar -->
  <div class="container-fluid p-0 flex-grow-1">
    <nav class="navbar navbar-expand-lg bg-info">
      <div class="container-fluid">
        <img src="./images/logo.png" alt="" class="logo">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="display_all.php">Products</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Register</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"><sup><?php
                   echo getCartProductNumber();
                ?></sup></i></a>
            </li>
          </ul> 
        </div>
      </div>
    </nav>
    <?php cart(); ?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
      <ul class="navbar-nav me-auto">
        <li class="nav-item ms-3">
          <a class="nav-link" href="#">Guest</a>
        </li>
        <li class="nav-item ms-3">
          <a class="nav-link" href="#">Login</a>
        </li>
      </ul>
    </nav>

    <div class="bg-light">
      <h3 class="text-center">Hidden Store</h3>
      <p class="text-center">Welcome to the world of football jerseys</p>
    </div>

    <!-- Cart Table -->
    <div class="container">
      <div class="row">
        <table class="table table-bordered text-center">
          <thead>
            <tr>
              <th>Product Image</th>
              <th>Product Name</th>
              <th>Quantity</th>
              <th>Total Price</th>
              <th>Remove</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $user_id = $_SESSION['id'];
            global $con;

            if (!$con) {
                die("Database connection failed: " . mysqli_connect_error());
            }

            $cart_query = "SELECT * FROM `cart` WHERE user_id = '$user_id'";
            $cart_result = mysqli_query($con, $cart_query);

            $cart_total = 0; // Initialize cart total to 0

            if (!$cart_result || mysqli_num_rows($cart_result) === 0) {
                echo "<tr><td colspan='5'>Your cart is empty.</td></tr>";
            } else {
                while ($cart_row = mysqli_fetch_array($cart_result)) {
                    $produkt_id = $cart_row['produkt_id'];
                    $quantity = $cart_row['quantity'];

                    $product_query = "SELECT produkt_name, produkt_image1, produkt_price FROM `produkt` WHERE produkt_id = '$produkt_id'";
                    $product_result = mysqli_query($con, $product_query);

                    if ($product_row = mysqli_fetch_array($product_result)) {
                        $produkt_name = $product_row['produkt_name'];
                        $produkt_image = $product_row['produkt_image1'];
                        $produkt_price = $product_row['produkt_price'];
                        $total_price = $produkt_price * $quantity;
                        $cart_total += $total_price;

                        echo "
                          <tr>
                            <td><img src='admin_manage/produkt_image/$produkt_image' alt='$produkt_name' width='100' height='100'></td>
                            <td>$produkt_name</td>
                            <td>
                              <div class='quantity-box'>
                                <button class='quantity-btn decrease' data-product-id='$produkt_id'>-</button>
                                <input type='number' value='$quantity' min='1' class='quantity-input' data-product-id='$produkt_id' readonly>
                                <button class='quantity-btn increase' data-product-id='$produkt_id'>+</button>
                              </div>
                            </td>
                            <td><span class='price' data-product-id='$produkt_id'>" . number_format($total_price, 2) . "</span></td>
                            <td>
                              <a href='remove.php?produkt_id=$produkt_id' class='remove-btn'>
                                <button class='btn btn-danger'>Remove</button>
                              </a>
                            </td>
                          </tr>
                        ";
                    }
                }
            }
            ?>
          </tbody>
        </table>

        <!-- Total Price and Checkout Button -->
        <div class="d-flex justify-content-between align-items-center mt-3">
          <h4>Total Price: $<span id="cart-total-price"><?php echo number_format($cart_total, 2); ?></span></h4>
          <a href="checkout.php" class="btn btn-primary">Go to Checkout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include("./includes/footer.php"); ?>
    
    <script>
        document.querySelectorAll('.quantity-btn').forEach(button => {
            button.addEventListener('click', function() {
                let productId = this.getAttribute('data-product-id');
                let inputField = document.querySelector(`.quantity-input[data-product-id='${productId}']`);
                let quantity = parseInt(inputField.value);
                if (this.classList.contains('increase')) {
                    quantity++;
                } else if (this.classList.contains('decrease') && quantity > 1) {
                    quantity--;
                }
                inputField.value = quantity;
                updateCartQuantity(productId, quantity);
            });
        });

        function updateCartQuantity(productId, quantity) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "update_cart.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    let response = xhr.responseText;
                    if (response !== 'error') {
                        let priceElement = document.querySelector(`.price[data-product-id='${productId}']`);
                        priceElement.textContent = "$" + (parseFloat(response)).toFixed(2);
                        updateCartTotalPrice();
                    } else {
                        alert("Error updating the cart.");
                    }
                }
            };
            xhr.send("product_id=" + productId + "&quantity=" + quantity);
        }

        function updateCartTotalPrice() {
            let total = 0;
            document.querySelectorAll('.price').forEach(priceElement => {
                total += parseFloat(priceElement.textContent.replace('$', ''));
            });
            document.getElementById('cart-total-price').textContent = total.toFixed(2);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
</body>

</html>
