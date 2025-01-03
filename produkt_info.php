<?php
session_start();
include('includes/connect.php');
include('functions/common_function.php');

// Check if the user is logged in and not verified
// Check if the user is logged in and not verified

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-Commerce Website </title>
  <!-- bootstrap CSS link -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- font awesome link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- css file -->
  <link rel="stylesheet" href="style.css">
  
  <style>
    
 

/* Content Wrapper */
#content-wrapper {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    margin: 20px auto;
}

/* Columns for Layout */
.column {
    width: 600px;
    padding: 10px;
    text-align: center;
}

/* Featured Image */
#featured {
    max-width: 500px;
    max-height: 600px;
    object-fit: cover;
    cursor: pointer;
    border: 2px solid black;
    margin: 0 auto;
    display: block;
}

/* Thumbnails Wrapper */
#thumbnails-wrapper {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 15px;
}

/* Thumbnail Images */
.thumbnail {
    object-fit: cover;
    max-width: 150px;
    max-height: 80px;
    cursor: pointer;
    opacity: 0.5;
    border: 2px solid black;
    transition: 0.3s ease;
}

.thumbnail:hover,
.thumbnail.active {
    opacity: 1;
    border-color: #007BFF; /* Highlight border when active */
}

/* Product Details */
.column h1 {
    font-size: 2rem;
    margin-bottom: 10px;
}

.column h3 {
    font-size: 1.5rem;
    color: #28a745;
}

.column p {
    font-size: 1rem;
    line-height: 1.5;
    color: #555;
    margin: 15px 0;
}


/* General Styling */
.size-selector, .custom-selector {
    margin: 15px 0;
}

label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
    color: #333;
    font-size: 16px;
}

.sizes, .custom-options {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

/* Button Styling */
.size-btn, .custom-btn {
    padding: 10px 15px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: bold;
    border: 1px solid #ddd;
    background-color: #f8f9fa;
    color: #333;
    cursor: pointer;
    transition: 0.3s ease;
}

.size-btn:hover, .custom-btn:hover {
    background-color: #ffc107; /* Yellow hover effect */
    color: #fff;
    
}

.size-btn.out-of-stock {
    background-color: #f1f1f1;
    color: #ccc;
    cursor: not-allowed;
    border: 1px solid #ddd;
}


/* Default size button style */
.size-btn {
    background-color: #f0f0f0; /* Light gray */
    color: #000; /* Black text */
    border: 1px solid #ccc; /* Light gray border */
    padding: 10px 20px;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
}

/* Style for the selected (active) size button */
.size-btn.active {
    background-color: #ffc107; /* Yellow background */
    color: #fff; /* White text */
    border: 1px solid #ffc107; /* Yellow border */
}

/* Style for out-of-stock buttons */
.size-btn.out-of-stock {
    background-color: #e0e0e0; /* Gray background */
    color: #a0a0a0; /* Light gray text */
    cursor: not-allowed;
    border: 1px solid #ccc; /* Light gray border */
    pointer-events: none; /* Disable all interactions */
}

/* Remove hover effect for disabled buttons */
.size-btn:disabled:hover,
.size-btn.out-of-stock:hover {
    background-color: #e0e0e0; /* Keep the same gray background */
    color: #a0a0a0; /* Keep the same light gray text */
    cursor: not-allowed;
    border: 1px solid #ccc;
}

/* Default Add to Cart button style */
.add-to-cart-btn {
    background-color: #343a40; /* Dark background */
    color: #fff; /* White text */
    border: 1px solid #343a40; /* Matching border */
    padding: 10px 20px;
    text-transform: uppercase;
    border-radius: 5px;
    font-size: 1rem;
    transition: background-color 0.3s ease, color 0.3s ease;
    cursor: default; /* Default cursor when not active */
    text-decoration: none; /* Remove underline from link */
}

/* Add to Cart button hover effect */
.add-to-cart-btn:hover {
    background-color: #23272b; /* Slightly darker background on hover */
    color: #ffce00; /* Highlighted text on hover */
    border-color: #ffce00; /* Matching hover border */
    cursor: pointer; /* Hand cursor on hover */
}







      </style>
</head>

<body>
  <!-- navbar -->
  <?php
      include("./includes/header.php")
    ?>

  <!-- thirrja e cart() -->
  
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #ffce00;">
  <ul class="navbar-nav me-auto">
    <?php
      if(!isset($_SESSION['id'])){
        echo '
          <li class="nav-item ms-3">
            <a class="nav-link" href="#" style="color: black !important;">Guest</a>
          </li>
          <li class="nav-item ms-3">
            <a class="nav-link" href="login.php" style="color: black !important;">Login</a>
          </li>
        ';
      }else{
        echo '
          <li class="nav-item ms-3">
            <a class="nav-link" href="logout.php" style="color: black !important;">Logout</a>
          </li>
          <li class="nav-item ms-3">
            <a class="nav-link" href="profile.php" style="color: black !important;">Profile</a>
          </li>
        ';
      }
    ?>
  </ul>
</nav>

    <div class="bg-light">
      <h3 class="text-center">Hidden Store</h3>
      <p class="text-center">Welcome to the world of football jerseys</p>
    </div>

    <div class="row px-1">
      <div class="col-md-10">
        <div class="row">
            
        
        

        <?php
             view_more();
             getproduktbyliga();
             getproduktbyekip();
             
         ?>
         
        </div>
      </div>

      <div class="col-md-2  p-0 ">
  <ul class="navbar-nav me-auto text-center" style="list-style-type: none; padding: 0; margin: 0;">
    <li class="nav-item bg-info" style="height: 50px;">
      <a class="nav-link text-light" href="#" style="background-color: #ffce00; color: black; display: flex; justify-content: center; align-items: center; height: 100%; padding-left: 0; padding-right: 0;">
        <span style="font-size: 18px; font-weight: bold;color: black;">Ligat</span>
      </a>
    </li>
    <?php
        getliga();
    ?>
  </ul>
  <ul class="navbar-nav me-auto text-center" style="list-style-type: none; padding: 0; margin: 0;">
    <li class="nav-item bg-info" style="height: 50px;">
      <a class="nav-link text-light" href="#" style="background-color: #ffce00; color: black; display: flex; justify-content: center; align-items: center; height: 100%; padding-left: 0; padding-right: 0;">
        <span style="font-size: 18px; font-weight: bold;color: black;">Ekipet</span>
      </a>
    </li>
    <?php
      getekip();
    ?>
  </ul>
</div>
    </div>




    <!-- footer -->
    <?php
      include("./includes/footer.php")
    ?>
    </div>


     





    <!-- bootstrap js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>

</body>

</html>