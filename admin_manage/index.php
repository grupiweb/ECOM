<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- css file -->
     <link rel="stylesheet" href="../style.css">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
<body>
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
                <img src="../images/logo.png" class="logo" alt="">
                <nav class="navbar navbar-expand-lg">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="" class="nav-link">Welcome Guest</a>

                        </li>
                    </ul>
                </nav>
            </div>
        </nav>
        <div class="bg-light">
            <h3 class="text-center">Manage Products</h3>
        </div>
        <div class="row">
            <div class="col-md-12 bg-secondary p-1 d-flex align-items-center">
               <div class="px-5"> 
                <a href="#"><img src="../images/admin-logo.png" class="admin_image" alt=""></a>
                <p class="text-light text-center">ADMIN NAME</p>
                </div>
                <div class="button text-center">
                    <button class="my-3"><a href="shto_produkt.php" class="nav-link text-light bg-info my-1">SHTO PRODUKT</a></button>
                    <button><a href="" class="nav-link text-light bg-info my-1">SHIKO PRODUKTET</a></button>
                    <button><a href="index.php?shto_liga" class="nav-link text-light bg-info my-1">SHTO LIGA</a></button>
                    <button><a href="" class="nav-link text-light bg-info my-1">SHIKO LIGA</a></button>
                    <button><a href="index.php?shto_ekipe" class="nav-link text-light bg-info my-1">SHTO EKIPE</a></button>
                    <button><a href="" class="nav-link text-light bg-info my-1">SHIKO EKIPE</a></button>
                    <button><a href="" class="nav-link text-light bg-info my-1">POROSITE</a></button>
                    <button><a href="" class="nav-link text-light bg-info my-1">PAGESAT</a></button>
                    <button><a href="" class="nav-link text-light bg-info my-1">PERDORUESIT</a></button>
                    <button><a href="" class="nav-link text-light bg-info my-1">LOGOUT</a></button>
                </div>
            </div>
        </div>

        <div class="container my-5">
            <?php
            if(isset($_GET['shto_liga'])){
               include('shto_liga.php'); 
            }
            if(isset($_GET['shto_ekipe'])){
                include('shto_ekipe.php'); 
             }
            ?>
        </div>


        <!-- footer -->
    <div class="bg-info p-3 text-center">
        <p>All rights reserved &copy by HJ</p>
     </div>
    </div>

    <!-- bootstrap js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>