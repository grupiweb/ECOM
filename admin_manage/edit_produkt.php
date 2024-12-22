<?php
// ob_start(); // Start output buffering

// if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
 //   header("Location: ../login.php");
 //   exit(); 
//}
// Fetch product details for editing

if (isset($_GET['edit_produkt'])) {
    $edit_id = $_GET['edit_produkt'];
    $get_data = "SELECT * FROM `produkt` WHERE produkt_id = $edit_id";
    $result = mysqli_query($con, $get_data);
    $row = mysqli_fetch_assoc($result);

    // Assign values to variables
    $product_name = $row['produkt_name'];
    $product_description = $row['produkt_description'];
    $product_keywords = $row['produkt_keywords'];
    $liga_id = $row['liga_id'];
    $ekip_id = $row['ekip_id'];
    $product_image1 = $row['produkt_image1'];
    $product_image2 = $row['produkt_image2'];
    $product_image3 = $row['produkt_image3'];
    $product_price = $row['produkt_price'];

    // Fetch Liga name
    $select_liga = "SELECT * FROM `liga` WHERE liga_id = $liga_id";
    $result_liga = mysqli_query($con, $select_liga);
    $row_liga = mysqli_fetch_assoc($result_liga);
    $liga_name = $row_liga['liga_name'];

    // Fetch Ekip name
    $select_ekip = "SELECT * FROM `ekip` WHERE ekip_id = $ekip_id";
    $result_ekip = mysqli_query($con, $select_ekip);
    $row_ekip = mysqli_fetch_assoc($result_ekip);
    $ekip_name = $row_ekip['ekip_name'];
}
?>

<div class="container mt-5">
    <h1 class="text-center">Edit Product</h1>
    <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>">
        <!-- Product Name -->
        <div class="form-outline w-50 m-auto mb-4">
            <label for="produkt_name" class="form-label">Product Name</label>
            <input type="text" id="produkt_name" name="produkt_name" class="form-control"
                   value="<?php echo htmlspecialchars($product_name); ?>" required>
        </div>

        <!-- Product Description -->
        <div class="form-outline w-50 m-auto mb-4">
            <label for="produkt_description" class="form-label">Product Description</label>
            <input type="text" id="produkt_description" name="produkt_description" class="form-control"
                   value="<?php echo htmlspecialchars($product_description); ?>" required>
        </div>

        <!-- Product Keywords -->
        <div class="form-outline w-50 m-auto mb-4">
            <label for="produkt_keywords" class="form-label">Product Keywords</label>
            <input type="text" id="produkt_keywords" name="produkt_keywords" class="form-control"
                   value="<?php echo htmlspecialchars($product_keywords); ?>" required>
        </div>

        <!-- Liga Dropdown -->
        <div class="form-outline w-50 m-auto mb-4">
            <label for="produkt_liga" class="form-label">Produkt Liga</label>
            <select name="produkt_liga" id="produkt_liga" class="form-select" onchange="filterTeamsByLiga()">
                <option value="<?php echo htmlspecialchars($liga_id); ?>"><?php echo htmlspecialchars($liga_name); ?></option>
                <?php
                $select_liga_all = "SELECT * FROM `liga`";
                $result_liga_all = mysqli_query($con, $select_liga_all);

                while ($row_liga_all = mysqli_fetch_assoc($result_liga_all)) {
                    $other_liga_id = $row_liga_all['liga_id'];
                    $other_liga_name = $row_liga_all['liga_name'];
                    if ($other_liga_id != $liga_id) {
                        echo "<option value='$other_liga_id'>" . htmlspecialchars($other_liga_name) . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <!-- Ekip Dropdown -->
        <div class="form-outline w-50 m-auto mb-4">
            <label for="produkt_ekip" class="form-label">Product Ekip</label>
            <select name="produkt_ekip" id="produkt_ekip" class="form-select">
                <option value="<?php echo htmlspecialchars($ekip_id); ?>"><?php echo htmlspecialchars($ekip_name); ?></option>
                <?php
                $select_ekip_all = "SELECT * FROM `ekip` WHERE liga_id = $liga_id";
                $result_ekip_all = mysqli_query($con, $select_ekip_all);

                while ($row_ekip_all = mysqli_fetch_assoc($result_ekip_all)) {
                    $other_ekip_id = $row_ekip_all['ekip_id'];
                    $other_ekip_name = $row_ekip_all['ekip_name'];
                    if ($other_ekip_id != $ekip_id) {
                        echo "<option value='$other_ekip_id'>" . htmlspecialchars($other_ekip_name) . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <!-- Product Image 1 -->
        <div class="form-outline w-50 m-auto mb-4">
            <label for="produkt_image1" class="form-label">Product Image 1</label>
            <div class="d-flex">
                <input type="file" id="produkt_image1" name="produkt_image1" class="form-control w-90 m-auto">
                <img src="./produkt_image/<?php echo $product_image1; ?>" alt="Image 1" class="produkt_image" width="100">
            </div>
        </div>

        <!-- Product Image 2 -->
        <div class="form-outline w-50 m-auto mb-4">
            <label for="produkt_image2" class="form-label">Product Image 2</label>
            <div class="d-flex">
                <input type="file" id="produkt_image2" name="produkt_image2" class="form-control w-90 m-auto">
                <img src="./produkt_image/<?php echo $product_image2; ?>" alt="Image 2" class="produkt_image" width="100">
            </div>
        </div>

        <!-- Product Image 3 -->
        <div class="form-outline w-50 m-auto mb-4">
            <label for="produkt_image3" class="form-label">Product Image 3</label>
            <div class="d-flex">
                <input type="file" id="produkt_image3" name="produkt_image3" class="form-control w-90 m-auto">
                <img src="./produkt_image/<?php echo $product_image3; ?>" alt="Image 3" class="produkt_image" width="100">
            </div>
        </div>

        <!-- Product Price -->
        <div class="form-outline w-50 m-auto mb-4">
            <label for="produkt_price" class="form-label">Product Price</label>
            <input type="text" id="produkt_price" name="produkt_price" class="form-control"
                   value="<?php echo htmlspecialchars($product_price); ?>" required>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <input type="submit" class="btn btn-info px-3 mb-3" name="edit_produkt" id="edit_produkt" value="Update Product">
        </div>
    </form>
</div>

<?php
// Update data

if (isset($_POST['edit_produkt'])) {
    // Get input data
    $edit_id=$_POST['edit_id'];
    $product_name = $_POST['produkt_name'];
    $product_description = $_POST['produkt_description'];
    $product_keywords = $_POST['produkt_keywords'];
    $liga_id = $_POST['liga_id'];
    $ekip_id = $_POST['ekip_id'];
    $product_price = $_POST['produkt_price'];
    $edit_id = $_POST['edit_id'];

    // Escape strings to prevent SQL injection
    $product_name = mysqli_real_escape_string($con, $product_name);
    $product_description = mysqli_real_escape_string($con, $product_description);
    $product_keywords = mysqli_real_escape_string($con, $product_keywords);
    $liga_id = mysqli_real_escape_string($con, $liga_id);
    $ekip_id = mysqli_real_escape_string($con, $ekip_id);
    $product_price = mysqli_real_escape_string($con, $product_price);
    $edit_id = mysqli_real_escape_string($con, $edit_id);

    // Handle images (check if files were uploaded)
    $product_image1 = isset($_FILES['produkt_image1']['name']) ? $_FILES['produkt_image1']['name'] : $product_image1;
    $product_image2 = isset($_FILES['produkt_image2']['name']) ? $_FILES['produkt_image2']['name'] : $product_image2;
    $product_image3 = isset($_FILES['produkt_image3']['name']) ? $_FILES['produkt_image3']['name'] : $product_image3;

    // Get temporary file paths
    $temp_image1 = $_FILES['produkt_image1']['tmp_name'];
    $temp_image2 = $_FILES['produkt_image2']['tmp_name'];
    $temp_image3 = $_FILES['produkt_image3']['tmp_name'];

    // Move uploaded files if new images are selected
    if ($temp_image1 && move_uploaded_file($temp_image1, "./produkt_image/$product_image1")) {
        // Successfully uploaded image1
    } else {
        // No new image uploaded for image1, retain old one
        $product_image1 = $row['produkt_image1']; // Keep old image
    }

    if ($temp_image2 && move_uploaded_file($temp_image2, "./produkt_image/$product_image2")) {
        // Successfully uploaded image2
    } else {
        // No new image uploaded for image2, retain old one
        $product_image2 = $row['produkt_image2']; // Keep old image
    }

    if ($temp_image3 && move_uploaded_file($temp_image3, "./produkt_image/$product_image3")) {
        // Successfully uploaded image3
    } else {
        // No new image uploaded for image3, retain old one
        $product_image3 = $row['produkt_image3']; // Keep old image
    }

    // Update the product details in the database
    $update_product = "UPDATE `produkt` 
                       SET produkt_name='$product_name', 
                           produkt_description='$product_description', 
                           produkt_keywords='$product_keywords', 
                           liga_id='$liga_id', 
                           ekip_id='$ekip_id', 
                           produkt_image1='$product_image1', 
                           produkt_image2='$product_image2', 
                           produkt_image3='$product_image3', 
                           produkt_price='$product_price', 
                           date=NOW() 
                       WHERE produkt_id='$edit_id'";

    // Execute the query
    $result_update = mysqli_query($con, $update_product);

    // Check if the update was successful
    if ($result_update) {
        echo "<script>alert('Produkti u editua me sukses');</script>";
        echo "<script>window.open('./index.php?view_products','_self');</script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>