<?php
if (isset($_GET['delete_produkt'])) {
    $delete_id = $_GET['delete_produkt'];

    // Delete query
    $delete_product = "DELETE FROM `produkt` WHERE produkt_id = $delete_id";
    $result_product = mysqli_query($con, $delete_product);

    if ($result_product) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                // Show a toast notification
                const toast = document.createElement('div');
                toast.style.position = 'fixed';
                toast.style.bottom = '20px';
                toast.style.right = '20px';
                toast.style.backgroundColor = '#28a745';
                toast.style.color = '#fff';
                toast.style.padding = '10px 20px';
                toast.style.borderRadius = '5px';
                toast.style.boxShadow = '0px 0px 10px rgba(0,0,0,0.2)';
                toast.textContent = 'Product deleted successfully!';
                document.body.appendChild(toast);
                
                // Remove the toast after 3 seconds
                setTimeout(() => toast.remove(), 3000);
            });
        </script>";
        
        // Redirect to index.php without blanking the page
        echo "<script>
            setTimeout(function() {
                window.location.href = './index.php?view_products';
            }, 3000);
        </script>";
    }
}
?>

