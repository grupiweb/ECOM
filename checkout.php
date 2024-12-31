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
  <?php
      include("./includes/header.php")
    ?>

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
      <h3 class="text-center">COMPLETE YOUR ORDER</h3>
      
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