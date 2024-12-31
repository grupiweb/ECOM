<?php
include('includes/connect.php');
include('functions/common_function.php');

session_start();

// Redirect if user is not logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Redirect if user's email is not verified
if (isset($_SESSION['id']) && $_SESSION['verified'] != '1') {
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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            flex: 1;
        }

        .btn-checkout {
            background-color: #ffce00;
            color: black;
            font-weight: bold;
            border: none;
        }

        .btn-checkout:hover {
            background-color: black;
            color: white;
        }

        footer {
            margin-top: auto;
        }

        .stock-info {
            font-size: 0.9em;
            color: #888;
            display: block;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <?php include("./includes/header.php"); ?>
    

    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <ul class="navbar-nav me-auto">
            <li class="nav-item ms-3">
                <a class="nav-link" href="#"><?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?></a>
            </li>
            <li class="nav-item ms-3">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>

    <div class="bg-light">
        <h3 class="text-center">Hidden Store</h3>
        <p class="text-center">Welcome to the world of football jerseys</p>
    </div>

    <!-- Cart Table -->
    <div class="container my-5">
        <div class="row">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
    <?php
    $user_id = $_SESSION['id'];
    $cart_total = 0;

    // Fetch cart details with size stock
    $cart_query = "
        SELECT c.*, p.produkt_name, p.produkt_image1, p.produkt_price, s.stock, s.size 
        FROM `cart` c 
        JOIN `produkt` p ON c.produkt_id = p.produkt_id 
        JOIN `sizes` s ON c.size_id = s.size_id 
        WHERE c.user_id = '$user_id'
    ";
    $cart_result = mysqli_query($con, $cart_query);

    if (mysqli_num_rows($cart_result) === 0) {
        echo "<tr><td colspan='6'>Your cart is empty.</td></tr>";
    } else {
        while ($cart_row = mysqli_fetch_assoc($cart_result)) {
            $size_id = $cart_row['size_id'];
            $quantity = $cart_row['quantity'];
            $produkt_name = $cart_row['produkt_name'];
            $produkt_image = $cart_row['produkt_image1'];
            $produkt_price = $cart_row['produkt_price'];
            $stock = $cart_row['stock'];
            $size = $cart_row['size'];
            $total_price = $produkt_price * $quantity;
            $cart_total += $total_price;
            $cart_id = $cart_row['cart_item_id'];
            ?>
            <tr>
                <td><img src="admin_manage/produkt_image/<?php echo htmlspecialchars($produkt_image); ?>" alt="<?php echo htmlspecialchars($produkt_name); ?>" width="100" height="100"></td>
                <td><?php echo htmlspecialchars($produkt_name); ?></td>
                <td><?php echo htmlspecialchars($size); ?></td> <!-- Added new <td> for Size -->
                <td>
                    <div class="quantity-box">
                        <button class="quantity-btn decrease" data-size-id="<?php echo $size_id; ?>">-</button>
                        <input type="number" value="<?php echo $quantity; ?>" min="1" class="quantity-input" data-size-id="<?php echo $size_id; ?>" readonly>
                        <button class="quantity-btn increase" data-size-id="<?php echo $size_id; ?>">+</button>
                    </div>
                    <span class="stock-info" data-size-id="<?php echo $size_id; ?>" data-stock="<?php echo $stock; ?>">(<?php echo $stock; ?> left)</span>
                </td>
                <td><span class="price" data-size-id="<?php echo $size_id; ?>"><?php echo number_format($total_price, 2); ?></span></td>
                <td>
                    <a href="remove.php?cart_id=<?php echo urlencode($cart_id); ?>" class="remove-btn">
                        <button class="btn btn-danger">Remove</button>
                    </a>
                </td>
            </tr>
            <?php
        }
    }
    ?>
</tbody>

            </table>

            <!-- Total Price and Checkout -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <h4>Total Price: $<span id="cart-total-price"><?php echo number_format($cart_total, 2); ?></span></h4>
                <a href="checkout.php" class="btn btn-checkout">Go to Checkout</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Hidden Store. All Rights Reserved.</p>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.querySelectorAll('.quantity-btn').forEach(button => {
    button.addEventListener('click', function () {
        const sizeId = this.getAttribute('data-size-id');
        const inputField = document.querySelector(`.quantity-input[data-size-id='${sizeId}']`);
        const stockSpan = document.querySelector(`.stock-info[data-size-id='${sizeId}']`);
        const maxStock = parseInt(stockSpan.dataset.stock); // Stock from data attribute
        let quantity = parseInt(inputField.value);

        if (this.classList.contains('increase')) {
            if (quantity < maxStock) {
                quantity++;
                inputField.value = quantity;
                updateCartQuantity(sizeId, quantity);
            }
            if (quantity === maxStock) {
                this.disabled = true; // Disable "Increase" button if stock is reached
            }
        } else if (this.classList.contains('decrease')) {
            if (quantity > 1) {
                quantity--;
                inputField.value = quantity;
                updateCartQuantity(sizeId, quantity);
            }
            document.querySelector(`.quantity-btn.increase[data-size-id='${sizeId}']`).disabled = false; // Re-enable "Increase" button
        }
    });
});

function updateCartQuantity(sizeId, quantity) {
    $.ajax({
        url: 'update_cart.php',
        type: 'POST',
        data: { size_id: sizeId, quantity: quantity },
        success: function (response) {
            const updatedPrice = parseFloat(response);
            if (!isNaN(updatedPrice)) {
                $(`.price[data-size-id='${sizeId}']`).text("$" + updatedPrice.toFixed(2));
                updateCartTotalPrice();
            } else {
                alert('Error updating the cart. Please try again.');
            }
        },
        error: function () {
            alert('Failed to update the cart.');
        }
    });
}

function updateCartTotalPrice() {
    let total = 0;
    $('.price').each(function () {
        total += parseFloat($(this).text().replace('$', ''));
    });
    $('#cart-total-price').text(total.toFixed(2));
}

    </script>
</body>

</html>
