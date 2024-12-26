<?php
session_start();

include('includes/connect.php');
include('functions/common_function.php');

// Check if the user is logged in and not verified
if (isset($_SESSION['id']) && $_SESSION['verified'] !== '1') {
  header('Location: verify.php');
  exit();
}
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

</head>

<body>
  <!-- navbar -->
  <div class="container-fluid p-0">
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
          </ul>
          <form class="d-flex" role="search" action="search_produkt.php" method="get">
            <input class="form-control me-2" type="search" name="search_produkt" placeholder="Search" aria-label="Search">
            <input type="submit" value="search" name="search_produkt_data" class="btn btn-outline-light">
          </form>
        </div>
      </div>
    </nav>

    <!-- secondary navbar -->
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

    <!-- welcome message -->
    <div class="bg-light">
      <h3 class="text-center">Hidden Store</h3>
      <p class="text-center">Welcome to the world of football jerseys</p>
    </div>

    <!-- content -->
    <div class="row px-1">
      <div class="col-md-12">
        <div class="row">
            <?php
          if(isset($_SESSION['username'])){
            include('user_manage/user_login.php');
          }else{
            include('payment.php');
          }
          ?>
        </div>
      </div>
    </div>
  </div>

  <!-- footer -->
  <?php include("./includes/footer.php"); ?>

  <!-- bootstrap js link -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>


</html>