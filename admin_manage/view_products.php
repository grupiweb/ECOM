<h3 class="text-center text-success">All Products</h3>
<table id="productTable" >
    <thead >
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Product Image</th>
            <th>Product Price</th>
        
            <th>Status</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody >
        <?php
            $get_products = "Select * from `produkt`";
            $result=mysqli_query($con,$get_products);
            $number = 0;
            while($row=mysqli_fetch_assoc($result)){
                $product_id = $row['produkt_id'];
                $product_name = $row['produkt_name'];
                $product_image1 = $row['produkt_image1'];
                $product_price = $row['produkt_price'];
                $product_status = $row['status'];
                $number++;
                ?>
                <tr class='text-center'>
            <td><?php echo $number; ?></td>
            <td><?php echo $product_name; ?></td>
            <td><img src='./produkt_image/<?php echo $product_image1; ?>' class='produkt_img' /></td>
            <td><?php echo $product_price; ?></td>
      
            <td><?php echo $product_status; ?></td>
            <td><a href='index.php?edit_produkt=<?php echo $product_id?>' ><i class='fa-solid fa-pen-to-square'></i></a></td>
            <td><a href='index.php?delete_produkt=<?php echo $product_id?>'><i class='fa-solid fa-trash'></i></a></td>
        </tr>
        <?php
            }
        ?>
        
            
    </tbody>
</table>
