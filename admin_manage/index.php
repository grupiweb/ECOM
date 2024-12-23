<?php
// Start the session and include necessary files
session_start();
ob_start();
include('../includes/connect.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- CSS and JS links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <!-- JS scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    
    <style>
        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
        }
        .produkt_img {
            width: 90px;
            object-fit: contain;
        }
        #productTable {
        border-collapse: collapse; /* Ensure borders collapse into a single line */
        width: 100%; /* Optional: Make the table full width */
    }

    /* Add borders to table cells */
    #productTable th, #productTable td {
        border: 1px solid #ddd; /* Add a light border */
        padding: 8px; /* Add padding for better spacing */
        text-align: center; /* Center-align table content */
    }

    /* Style the table header */
    #productTable thead {
        background-color: #17a2b8; /* Set header background color */
        color: white; /* Set header text color */
    }

    /* Add hover effect on rows */
    #productTable tbody tr:hover {
        background-color: #f1f1f1; /* Light gray hover color */
    }

    </style>
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
                <button><a href="index.php?view_products" class="nav-link text-light bg-info my-1">SHIKO PRODUKTET</a></button>
                <button><a href="index.php?shto_liga" class="nav-link text-light bg-info my-1">SHTO LIGA</a></button>
                <button><a href="index.php?shiko_liga" class="nav-link text-light bg-info my-1">SHIKO LIGA</a></button>
                <button><a href="index.php?shto_ekipe" class="nav-link text-light bg-info my-1">SHTO EKIPE</a></button>
                <button><a href="index.php?shiko_ekip" class="nav-link text-light bg-info my-1">SHIKO EKIPE</a></button>
                <button><a href="" class="nav-link text-light bg-info my-1">POROSITE</a></button>
                <button><a href="" class="nav-link text-light bg-info my-1">PAGESAT</a></button>
                <button><a href="" class="nav-link text-light bg-info my-1">PERDORUESIT</a></button>
                <button><a href="" class="nav-link text-light bg-info my-1">LOGOUT</a></button>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <?php
        if (isset($_GET['shto_liga'])) {
            include('shto_liga.php');
        }
        if (isset($_GET['shto_ekipe'])) {
            include('shto_ekipe.php');
        }
        if (isset($_GET['view_products'])) {
            include('view_products.php');
        }
        if (isset($_GET['edit_produkt'])) {
            include('edit_produkt.php');
        }
        if (isset($_GET['delete_produkt'])) {
            include('delete_produkt.php');
        }
        if (isset($_GET['shiko_liga'])) {
            include('shiko_liga.php');
        }
        if (isset($_GET['shiko_ekip'])) {
            include('shiko_ekip.php');
        }
        if (isset($_GET['edit_liga'])) {
            include('edit_liga.php');
        }
        if (isset($_GET['edit_ekip'])) {
            include('edit_ekip.php');
        }
        if (isset($_GET['delete_ekip'])) {
            include('delete_ekip.php');
        }
        if (isset($_GET['delete_liga'])) {
            include('delete_liga.php');
        }
        ?>
    </div>

    <?php include("../includes/footer.php"); ?>
</div>




<script>
    $(document).ready(function () {
        $('#productTable').DataTable();
    });
</script>
<script>
    function filterTeamsByLiga() {
        const ligaId = document.getElementById('produkt_liga').value;

        // Create a FormData object
        const data = new FormData();
        data.append("liga_id", ligaId);

        // AJAX call to the backend
        $.ajax({
            type: "POST",
            url: "fetch_teams.php", // Call to fetch_teams.php
            async: false,
            cache: false,
            processData: false,
            data: data,
            contentType: false,
            success: function(response) {
                const ekipSelect = document.getElementById('produkt_ekip');
                ekipSelect.innerHTML = `<option value="" disabled selected>Zgjidh nje ekip</option>` + response; // Add the default option
            },
            error: function() {
                console.error("An error occurred while fetching teams.");
            }
        });
    }
</script>


</body>
</html>
