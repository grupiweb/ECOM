<?php
session_start();
include('includes/connect.php');
include('functions/common_function.php');

// Check if the user is logged in and not verified
if (!isset($_SESSION['id'])) {
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
  <?php
      include("./includes/header.php")
    ?>
      <!-- thirrja e cart() -->
       <?php
       cart();
       ?>

    <nav class="nabar navbar-expand-lg navbar-dark bg-secondary">
      <ul class="navbar-nav me-auto">
        <?php
          if(!isset($_SESSION['id'])){
            echo '
              <li class="nav-item ms-3">
                <a class="nav-link" href="#">Guest</a>
              </li>
              <li class="nav-item ms-3">
                <a class="nav-link" href="login.php">Login</a>
              </li>
            ';
          }else{
            echo '
              <li class="nav-item ms-3">
                <a class="nav-link" href="logout.php">Logout</a>
              </li>
              <li class="nav-item ms-3">
                <a class="nav-link" href="profile.php">Profile</a>
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
             getprodukt();
             getproduktbyliga();
             getproduktbyekip();
             
         ?>
         
        </div>
      </div>

      <div class="col-md-2 bg-secondary p-0">
        <ul class="navbar-nav me-auto text-center">
          <li class="nav-item bg-info">
            <a class="nav-link text-light" href="#">
              <h4>Ligat</h4>
            </a>
          </li>
          <?php
              getliga();
          ?>

        </ul>
        <ul class="navbar-nav me-auto text-center">
          <li class="nav-item bg-info">
            <a class="nav-link text-light" href="#">
              <h4>Ekipet</h4>
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