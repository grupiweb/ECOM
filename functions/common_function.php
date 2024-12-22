<?php

include('./includes/connect.php');

    function getprodukt(){
        global $con;
        if(!isset($_GET['liga'])){
            if(!isset($_GET['ekip'])){
          $select_query="Select * from `produkt` order by rand() limit 0,9";
          $result_query=mysqli_query($con,$select_query);
          while($row=mysqli_fetch_assoc($result_query)){
            $produkt_id=$row['produkt_id'];
            $produkt_name=$row['produkt_name'];
            $produkt_description=$row['produkt_description'];
            $produkt_image1=$row['produkt_image1'];
            $produkt_price=$row['produkt_price'];
            $liga_id=$row['liga_id'];
            $ekip_id=$row['ekip_id'];
            echo "<div class='col-md-4'>
            <div class='card' style='width: 18rem;'>
              <img src='./admin_manage/produkt_image/$produkt_image1' class='card-img-top' alt='$produkt_name'>
              <div class='card-body'>
                <h5 class='card-title'>$produkt_name</h5>
                <p class='card-text'>$produkt_description</p>
                <p class='card-text'>$produkt_price $</p>
                <a href='index.php?add_to_cart=$produkt_id' class='btn btn-info'>Add To Cart</a>
                <a href='produkt_info.php?produkt_id=$produkt_id' class='btn btn-secondary'>View More</a>
              </div>
            </div>
          </div>";
          }
        }
    }
}

function get_all_produkt(){
    global $con;
    if(!isset($_GET['liga'])){
        if(!isset($_GET['ekip'])){
      $select_query="Select * from `produkt` order by rand()";
      $result_query=mysqli_query($con,$select_query);
      while($row=mysqli_fetch_assoc($result_query)){
        $produkt_id=$row['produkt_id'];
        $produkt_name=$row['produkt_name'];
        $produkt_description=$row['produkt_description'];
        $produkt_image1=$row['produkt_image1'];
        $produkt_price=$row['produkt_price'];
        $liga_id=$row['liga_id'];
        $ekip_id=$row['ekip_id'];
        echo "<div class='col-md-4'>
        <div class='card' style='width: 18rem;'>
          <img src='./admin_manage/produkt_image/$produkt_image1' class='card-img-top' alt='$produkt_name'>
          <div class='card-body'>
            <h5 class='card-title'>$produkt_name</h5>
            <p class='card-text'>$produkt_description</p>
            <p class='card-text'>$produkt_price $</p>
            <a href='index.php?add_to_cart=$produkt_id' class='btn btn-info'>Add To Cart</a>
             <a href='produkt_info.php?produkt_id=$produkt_id' class='btn btn-secondary'>View More</a>
          </div>
        </div>
      </div>";
      }
    }
}
}


function getproduktbyliga(){
    global $con;
    if(isset($_GET['liga'])){
    $liga_id= $_GET['liga'];  
      $select_query="Select * from `produkt` where liga_id=$liga_id";
      $result_query=mysqli_query($con,$select_query);
      $num_of_rows=mysqli_num_rows($result_query);
      if($num_of_rows==0){
        echo "<h2 class='text-center text-danger'>Nuk ka stok per kete lige.";
      }      
      while($row=mysqli_fetch_assoc($result_query)){
        $produkt_id=$row['produkt_id'];
        $produkt_name=$row['produkt_name'];
        $produkt_description=$row['produkt_description'];
        $produkt_image1=$row['produkt_image1'];
        $produkt_price=$row['produkt_price'];
        $liga_id=$row['liga_id'];
        $ekip_id=$row['ekip_id'];
        echo "<div class='col-md-4'>
        <div class='card' style='width: 18rem;'>
          <img src='./admin_manage/produkt_image/$produkt_image1' class='card-img-top' alt='$produkt_name'>
          <div class='card-body'>
            <h5 class='card-title'>$produkt_name</h5>
            <p class='card-text'>$produkt_description</p>
            <p class='card-text'>$produkt_price $</p>
            <a href='index.php?add_to_cart=$produkt_id' class='btn btn-info'>Add To Cart</a>
             <a href='produkt_info.php?produkt_id=$produkt_id' class='btn btn-secondary'>View More</a>
          </div>
        </div>
      </div>";
      }
    }
}

function getproduktbyekip(){
    global $con;
    if(isset($_GET['ekip'])){
    $ekip_id= $_GET['ekip'];  
      $select_query="Select * from `produkt` where ekip_id=$ekip_id";
      $result_query=mysqli_query($con,$select_query);
      $num_of_rows=mysqli_num_rows($result_query);
      if($num_of_rows==0){
        echo "<h2 class='text-center text-danger'>Nuk ka stok per kete ekip.";
      }      
      while($row=mysqli_fetch_assoc($result_query)){
        $produkt_id=$row['produkt_id'];
        $produkt_name=$row['produkt_name'];
        $produkt_description=$row['produkt_description'];
        $produkt_image1=$row['produkt_image1'];
        $produkt_price=$row['produkt_price'];
        $liga_id=$row['liga_id'];
        $ekip_id=$row['ekip_id'];
        echo "<div class='col-md-4'>
        <div class='card' style='width: 18rem;'>
          <img src='./admin_manage/produkt_image/$produkt_image1' class='card-img-top' alt='$produkt_name'>
          <div class='card-body'>
            <h5 class='card-title'>$produkt_name</h5>
            <p class='card-text'>$produkt_description</p>
            <p class='card-text'>$produkt_price $</p>
            <a href='index.php?add_to_cart=$produkt_id' class='btn btn-info'>Add To Cart</a>
             <a href='produkt_info.php?produkt_id=$produkt_id' class='btn btn-secondary'>View More</a>
          </div>
        </div>
      </div>";
      }
    }
}



    function getliga(){
        global $con;
        $select_liga = "Select * from `liga`";
          $result_liga = mysqli_query($con, $select_liga);

          while ($row_data = mysqli_fetch_assoc($result_liga)) {
            $liga_name = $row_data['liga_name'];
            $liga_id = $row_data['liga_id'];
            echo "<li class='nav-item'>
            <a class='nav-link text-light' href='index.php?liga=$liga_id'>$liga_name</a>
          </li>";
          }
    }

    function getekip(){
        global $con;
        $select_ekip = "Select * from `ekip`";
        $result_ekip = mysqli_query($con, $select_ekip);

        while ($row_data = mysqli_fetch_assoc($result_ekip)) {
          $ekip_name = $row_data['ekip_name'];
          $ekip_id = $row_data['ekip_id'];
          echo "<li class='nav-item'>
          <a class='nav-link text-light' href='index.php?ekip=$ekip_id'>$ekip_name</a>
        </li>";
        }
    }
          
    function search_produkt(){
        global $con;
        if(isset($_GET['search_produkt'])){
          $search_produkt_value=$_GET['search_produkt'];
          $search_query="Select * from `produkt` where produkt_keywords like '%$search_produkt_value%'";
          $result_query=mysqli_query($con,$search_query);
          $num_of_rows=mysqli_num_rows($result_query);
          if($num_of_rows==0){
          echo "<h2 class='text-center text-danger'>Produkti qe kerkoni nuk ekziston.";
          } 
          while($row=mysqli_fetch_assoc($result_query)){
            $produkt_id=$row['produkt_id'];
            $produkt_name=$row['produkt_name'];
            $produkt_description=$row['produkt_description'];
            $produkt_image1=$row['produkt_image1'];
            $produkt_price=$row['produkt_price'];
            $liga_id=$row['liga_id'];
            $ekip_id=$row['ekip_id'];
            echo "<div class='col-md-4'>
            <div class='card' style='width: 18rem;'>
              <img src='./admin_manage/produkt_image/$produkt_image1' class='card-img-top' alt='$produkt_name'>
              <div class='card-body'>
                <h5 class='card-title'>$produkt_name</h5>
                <p class='card-text'>$produkt_description</p>
                <p class='card-text'>$produkt_price $</p>
            <a href='index.php?add_to_cart=$produkt_id' class='btn btn-info'>Add To Cart</a>
                <a href='#' class='btn btn-secondary'>View More</a>
              </div>
            </div>
          </div>";
          }
        }
      }

      function view_more(){
        global $con;
        if(isset($_GET['produkt_id'])){
        if(!isset($_GET['liga'])){
            if(!isset($_GET['ekip'])){
              $produkt_id=$_GET['produkt_id'];
              $select_query="Select * from `produkt` where produkt_id=$produkt_id";
          $result_query=mysqli_query($con,$select_query);
          while($row=mysqli_fetch_assoc($result_query)){
            $produkt_id=$row['produkt_id'];
            $produkt_name=$row['produkt_name'];
            $produkt_description=$row['produkt_description'];
            $produkt_image1=$row['produkt_image1'];
            $produkt_image2=$row['produkt_image2'];
            $produkt_image3=$row['produkt_image3'];
            $produkt_price=$row['produkt_price'];
            $liga_id=$row['liga_id'];
            $ekip_id=$row['ekip_id'];
            echo "<div class='col-md-4'>
            <div class='card' style='width: 18rem;'>
              <img src='./admin_manage/produkt_image/$produkt_image1' class='card-img-top' alt='$produkt_name'>
              <div class='card-body'>
                <h5 class='card-title'>$produkt_name</h5>
                <p class='card-text'>$produkt_description</p>
                <p class='card-text'>$produkt_price $</p>
                <a href='index.php?add_to_cart=$produkt_id' class='btn btn-info'>Add To Cart</a>
                <a href='index.php' class='btn btn-secondary'>Home</a>
              </div>
            </div>
          </div>
          <div class='col-md-8'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='text-center text-info mb-5'>Reth Produktit</h4>
                </div>
                
                <div class='col-md-6'>
                <img src='./admin_manage/produkt_image/$produkt_image2' class='card-img-top' alt='$produkt_name'>
                </div>
                <div class='col-md-6'>
                <img src='./admin_manage/produkt_image/$produkt_image3' class='card-img-top' alt='$produkt_name'>
                </div>
            </div>
        </div>
          ";
          }
        }
    }
      }
    }

    //cart function
    function cart() {
      if (isset($_GET['add_to_cart'])) {
          global $con;
          
          // Get the logged-in user's ID
          session_start();
          if (!isset($_SESSION['user_id'])) {
              echo "<script>alert('You need to log in to add products to the cart')</script>";
              echo "<script>window.open('login.php','_self')</script>";
              return;
          }
          
          $user_id = $_SESSION['user_id'];
          $get_produkt_id = $_GET['add_to_cart'];
          
          // Check if the product is already in the cart for this user
          $select_query = "SELECT * FROM `cart` WHERE user_id = '$user_id' AND produkt_id = '$get_produkt_id'";
          $result_query = mysqli_query($con, $select_query);
          $num_of_rows = mysqli_num_rows($result_query);
          
          if ($num_of_rows > 0) {
              echo "<script>alert('This product is already in your cart')</script>";
              echo "<script>window.open('index.php','_self')</script>";
          } else {
              // Add the product to the cart
              $insert_query = "INSERT INTO `cart` (user_id, produkt_id, quantity) VALUES ('$user_id', '$get_produkt_id', 1)";
              $result_query = mysqli_query($con, $insert_query);
              if ($result_query) {
                  echo "<script>alert('Product added to your cart')</script>";
                  echo "<script>window.open('index.php','_self')</script>";
              } else {
                  echo "<script>alert('Failed to add product to cart')</script>";
              }
          }
      }
  }

function totalPrice() {
  global $con;

 
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }

  $total = 0;

  
  if (!isset($_SESSION['user_id'])) {
      echo 0; // If user is not logged in, total is 0
      return;
  }

  $user_id = $_SESSION['user_id'];

  
  $cart_query = "SELECT * FROM `cart` WHERE user_id='$user_id'";
  $result = mysqli_query($con, $cart_query);

  
  while ($row = mysqli_fetch_array($result)) {
      $produkt_id = $row['produkt_id'];

      
      $price_query = "SELECT produkt_price FROM `produkt` WHERE produkt_id='$produkt_id'";
      $result_price = mysqli_query($con, $price_query);

      
      while ($row_price = mysqli_fetch_array($result_price)) {
          $produkt_price = (float)$row_price['produkt_price']; // Ensure the price is treated as a number
          $total += $produkt_price;
      }
  }

  echo $total; 
}


function getCartProductNumber() {
  global $con;

  
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }

  // Check if user is logged in
  if (!isset($_SESSION['user_id'])) {
      return 0; // Return 0 if not logged in
  }

  $user_id = $_SESSION['user_id'];
  $query = "SELECT * FROM cart WHERE user_id = '$user_id'";
  $result = mysqli_query($con, $query);

  if ($result) {
      return mysqli_num_rows($result);   
  } else {
      return 0; 
  }
}


?>